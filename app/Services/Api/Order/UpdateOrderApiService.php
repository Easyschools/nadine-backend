<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 08/12/20
 * Time: 02:53 م
 */

namespace App\Services\Api\Order;

use App\Models\Order\Coupon;
use App\Models\Order\Helpers\UpdateOrderHelpers;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderItemServiceModelSparePart;
use App\Models\Order\PaymentType;
use App\Models\Service\ModelServic;
use App\Models\Service\ServiceModelSparePart;
use App\Models\User\Address;
use App\Models\User\User;
use App\Repositories\AppRepository;
use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpdateOrderApiService extends AppRepository
{
    private $order;
    private $grandTotal;
    private $subtotal;
    private $tax;
    private $couponPrice = 0;
    private $maxDiscountValue = 0;
    private $items;
    private $is_updated = 0;
    private $handle_addition = 0;

    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function updateStatus(Request $request)
    {
        $user = Auth::user();
//        if ($user->type == 4 && $request->status != 5) {
        if ($user->type == 4 && $request->status != 4) {
            return false;
        }
//        if ($user->type == 3 && !in_array($request->status, [6, 7, 8, 9, 10])) {
        if ($user->type == 3 && !in_array($request->status, [5, 6, 7, 8, 9])) {
            return false;
        }

        $order = $this->find($request->id);


        $orderStatus = new \ReflectionClass(new OrderStatus());
        $constants = array_flip($orderStatus->getConstants());
        $status = $constants[$request->status];

        /***************************/
        $data = [
            'msg' => ' order ' . $order->code . ' status is updated to: ' . $status,
            'to' => "admin,customer,operation",
            'order_id' => $order->id,
        ];

        OrderNotificationHelper::sendNotificationsForOrder($request, $order, $data, 3, $status);

        /*******************************/


        //update membership
        if ($request->status == 9 || $request->status == 8) {
            dispatch(new UpdateMembershipJob($user, $order));
        }


        return $order->update([
            'status' => $request->status,
        ]);
    }

    public function updatePayment(Request $request)
    {
        $user = Auth::user();
//        if ($user->type == 4 && $request->status != 5) {
        if ($user->type == 4) {
            return false;
        }

        $order = $this->find($request->id);

        $paymentType = PaymentType::findOrFail($request->payment_type_id);

        /***************************/
        $data = [
            'msg' => ' order ' . $order->code . ' payment is updated to: ' . $paymentType->name,
            'to' => "admin,customer,operation,technician",
            'order_id' => $order->id,
        ];

        OrderNotificationHelper::sendNotificationsForOrder($request, $order, $data, 3);

        /*******************************/


//        //update membership
//        dispatch(new UpdateMembershipJob($user));


        return $order->update([
            'payment_type_id' => $request->payment_type_id,
        ]);
    }

    private function serOrder($orderId)
    {
        $this->setRelations([
            'items' => function ($item) {
                $item->select('id', 'service_model_id', 'order_id', 'item_cost', 'order_item_labour_price')
                    ->with([
                        'serviceModel' => function ($serviceModel) use ($item) {
                            $serviceModel->with([
                                'orderItemServiceSpareParts' => function ($spare_part) use ($item) {
                                    $spare_part->whereIn('order_item_id', $item->pluck('id')->toArray());
                                },
                            ]);
                        }
                    ]);
            },
            'slot:id,end,start,active'
        ]);

        $this->order = $this->find($orderId);
    }

    private function setItems(array $items)
    {
        $serviceRepo = new AppRepository(new ModelServic());
        $this->items = $serviceRepo->model->whereIn('id', $items)
            ->get();
    }


    public function getCouponPrice($couponId)
    {
        if (!$couponId)
            return;

        $couponRepo = new AppRepository(new Coupon());
        $coupon = $couponRepo->find($couponId);
        $this->couponPrice = round(($coupon->is_percentage == 1) ?
            $this->subtotal * ($coupon->value / 100) : $coupon->value, 3);
    }

    public function getMaxDiscountValue()
    {
        $membership = $this->order->customer->membership;

        if ($membership->is_percentage) {
            $membership_discount = $this->subtotal * $membership->discount / 100;
        } else {
            $membership_discount = $membership->discount;
        }

        $this->maxDiscountValue = max($membership_discount, $this->couponPrice);

    }

    public function setTax($addressId)
    {
        $addressRepo = new AppRepository(new Address());
        $addressRepo->setRelations(['country:id,vat']);
        $address = $addressRepo->find($addressId);
        $this->tax = round(($this->subtotal - $this->maxDiscountValue) * ($address->country->vat / 100));
    }

    private function checkChangesConditions()
    {
        $cond1 = $this->order->status_original_id < 4 ? false : true;
        $diffTime = (strtotime($this->order->slot->start) - strtotime(date('H:i'))) / 3600;
        $cond2 = $diffTime > 5 && $this->order->day <= date('Y-m-d');
        if ($cond1 || $cond2) {
            throw ValidationException::withMessages([
                'order' => ['sorry,cant edit this order'],
            ]);
        }
    }


    /**
     * handle delete ,edit, and labours part
     *
     * @param Request $request
     * @param $operation
     * @return mixed
     */
    public function recalculateForSparePart(Request $request, $operation)
    {

        if ($operation == 'update_labours') {

            $elements = $request->labours;
        } else {
            $elements = $operation == 'delete' ? $request->spare : $request->spare_quantity;
        }

        $this->subtotal = $this->order->subtotal;

        $this->grandTotal = $this->order->grandTotal;

        foreach ($elements as $element) {

            $subtotal = $this->subtotal;

            $grandTotal = $this->grandTotal;

            $order_item = OrderItem::findOrFail($element['item_id']);

            if ($operation != 'update_labours')
                $itemofsparepart = OrderItemServiceModelSparePart::findOrFail($element['id']);

            $subtotal_order_item = $order_item->item_cost;


            $res = $order_item->order_item_labour_price;

            if ($operation == 'update') {

                $finalResult = abs($element['qty'] - $itemofsparepart->quantity) * $itemofsparepart->cost;

                if ($element['qty'] < $itemofsparepart->quantity) {

                    list($subtotal, $grandTotal, $subtotal_order_item) = UpdateOrderHelpers::calculateTotalsNegativeSign($subtotal, $grandTotal, $subtotal_order_item, $finalResult);

                } elseif ($element['qty'] > $itemofsparepart->quantity) {

                    list($subtotal, $grandTotal, $subtotal_order_item) = UpdateOrderHelpers::calculateTotalsPositiveSign($subtotal, $grandTotal, $subtotal_order_item, $finalResult);

                }

                $itemofsparepart->update([
                    'quantity' => $element['qty'],
                ]);

            } elseif ($operation == 'delete') {
                $res = $itemofsparepart->cost * $itemofsparepart->quantity;

                list($subtotal, $grandTotal, $subtotal_order_item) = UpdateOrderHelpers::calculateTotalsNegativeSign($subtotal, $grandTotal, $subtotal_order_item, $res);

                $itemofsparepart->delete();

            } else {
                $labour_price_old = $order_item->order_item_labour_price;

                $res = $element['labour_price'];

                list($subtotal, $grandTotal, $subtotal_order_item) = UpdateOrderHelpers::calculateTotalsPositiveSign($subtotal, $grandTotal, $subtotal_order_item, $res);

                list($subtotal, $grandTotal, $subtotal_order_item) = UpdateOrderHelpers::calculateTotalsNegativeSign($subtotal, $grandTotal, $subtotal_order_item, $labour_price_old);
            }

            $this->subtotal = $subtotal;

            $this->grandTotal = $grandTotal;

            $order_item->update([
                'item_cost' => $subtotal_order_item,
                'order_item_labour_price' => $res,
            ]);
        }
    }

    /**
     * check for request and redirect it
     *
     * @param Request $request
     * @return void
     */
    public function handleAdditionalSpareParts(Request $request)
    {

        if (!empty($request->spare_quantity)) {
            $this->handle_addition = 1;
            $this->recalculateForSparePart($request, 'update');
        }

        if (!empty($request->spare)) {
            $this->handle_addition = 1;
            $this->recalculateForSparePart($request, 'delete');
        }

        if (!empty($request->labours)) {
            $this->handle_addition = 1;
            $this->recalculateForSparePart($request, 'update_labours');
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function recalculate(Request $request)
    {
        $this->serOrder($request->id);

        if (Auth::user()->type == 4) {
            $this->checkChangesConditions();
        }
        $this->setItems($request->items);

        if ($this->is_updated)
            UpdateOrderHelpers::makeOrderHistory($this->order);

        $this->subtotal = $this->order->subtotal;

        $order_items = $this->order->items();

        $order_items_service_model_ids = $order_items->pluck('service_model_id')->toArray();

        $this->tax = $this->tax == null ? $this->order->tax : $this->tax;

        if (!$this->is_updated) {

            foreach ($this->items as $item) {

                $item['item_cost'] = $item->cost;

                if (!in_array($item->id, $order_items_service_model_ids)) {
                    $this->subtotal += $item->cost;
                }

            }
        }


        if ($this->is_updated) {

            $this->handleAdditionalSpareParts($request);
        }
//        if (!$this->is_updated) {

        $this->getCouponPrice($this->order->coupon_id);

        $this->getMaxDiscountValue();

        if ($request->address_id) {

            $this->setTax($request->address_id);
        }


        $this->grandTotal = round($this->subtotal + $this->tax - $this->maxDiscountValue, 3);

        return [
            'vat' => $this->tax == null ? $this->order->tax : $this->tax,
            'subtotal' => $this->subtotal,
            'discount_value' => $this->maxDiscountValue,
            'grand_total' => $this->grandTotal,
        ];
    }

    /**
     *
     * @param Request $request
     * @return mixed
     */
    public function updateOrder(Request $request)
    {
        $this->is_updated = 1;

        $this->recalculate($request);

        $orderServiceModelIds = $this->order->items()->pluck('service_model_id');

        list($this->subtotal, $this->grandTotal, $flag, $orderServiceModelIds) =
            UpdateOrderHelpers::deleteItemsOfOrders($request, $orderServiceModelIds, $this->order, $this->subtotal, $this->grandTotal, 0);

//        dd($this->subtotal);
        if (!$this->subtotal) return 'error';
        $change = 1;

        foreach ($this->items as $item) {
            list($this->subtotal, $this->grandTotal, $flag) = UpdateOrderHelpers::editItemsOfOrders($item, $orderServiceModelIds, $this->order, $this->subtotal, $this->grandTotal, 0);
            if ($flag != 0) {
                $change = 1;
            }
        }

        if (($flag || $change) && !$this->handle_addition) {
            $this->getCouponPrice($this->order->coupon_id);

            $this->getMaxDiscountValue();

            $this->setTax($this->order->address_id);

            $this->grandTotal = round($this->subtotal + $this->tax - $this->maxDiscountValue, 3);

        }

        if ($request) {
            $this->order->update(array_merge($request->all(), [
                'subtotal' => $this->subtotal,
                'tax' => $this->tax == null ? $this->order->tax : $this->tax,
                'coupon_price' => $this->couponPrice,
                'grand_total' => $this->grandTotal,
                'discount_value' => $this->maxDiscountValue,
                'user_id' => $this->order->user_id,
                'coupon_id' => $this->order->coupon_id,
                'status' => $this->order->status_id,
                'is_edited' => 1,
                'payment_type_id' => $request->payment_type_id,
            ]));
        } else {
            $this->order->update(array_merge($request->all(), [
                'subtotal' => $this->subtotal,
                'grand_total' => $this->grandTotal,
            ]));

        }
        $this->is_updated = 0;
        return $this->order;
    }


}
