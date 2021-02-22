<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 03/12/20
 * Time: 10:37 ص
 */

namespace App\Services\Order;
use App\Models\Order\Coupon;
use App\Models\Order\Order;
use App\Models\User\User;
use App\Product\Variant;
use App\Repositories\AppRepository;
use App\Traits\FirebaseFCM;
use Faker\Provider\DateTime;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderApiService extends AppRepository
{
    use FirebaseFCM;

    private $cartRepo;
    private $address;
    private $status = 1;
    private $subtotal;
    private $grandTotal;
    private $coupon = null;
    private $couponPrice = 0;
    private $maxDiscountValue = 0;
    private $tax;
    private $carts;


    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function setCarts($request)
    {
        $this->cartRepo = new AppRepository(new Variant());
        $this->carts = $this->cartRepo->model
            ->whereIn('id',$request->variants)
            ->with('product')
            ->get();
    }

//    public function setTax($addressId)
//    {
//        $this->address = new AppRepository(new Address());
//        $this->address->setRelations(['country:id,vat']);
//
//        $this->address = $this->address->find($addressId);
//        $taxValue = round(($this->subtotal - $this->maxDiscountValue) * ($this->address->country->vat / 100));
//        $this->tax = $taxValue >= 0 ? $taxValue : 0;
//    }

    public function calculate($request)
    {
        $user = User::with([
            'orders' => function ($order) {
                $order->select('id');
            }
        ])->findOrFail(Auth::id());


        $this->setCarts($request);

        if (count($this->carts) == 0) {
            throw ValidationException::withMessages([
                ['please,add service to cart'],
            ]);
        }
        foreach ($this->carts as $cart) {
            $cart['item_cost'] = $cart->serviceModel->cost;
            $this->subtotal += $cart->additional_price;
        }
        return [
            'subtotal' => $this->subtotal,
            'items' => $this->carts,
        ];
    }

    public function getCouponPrice($code, $subtotal)
    {
        $couponRepo = new AppRepository(new Coupon());
        $conditions = [];
//        $conditions[] = ['from', '<=', date('Y-m-d')];
        $conditions[] = ['expire_at', '>=', date(now())];
        $couponRepo->setConditions($conditions);
        $coupon = $couponRepo->findByColumn('code', $code);
        if (!$coupon) {
            return;
        }
        if ($coupon->max_num <= $coupon->used_times) {
            return;
        }
        $this->coupon = $coupon;
        $this->couponPrice = ($coupon->is_percentage == 1) ? round(
            $subtotal * ($coupon->value / 100), 3) : $coupon->value;
    }

    public function grandTotal(Request $request)
    {
        $calculate = $this->calculate();
        $this->getCouponPrice($request->code, $this->subtotal);

        $membership = Auth::user()->membership;

        if ($membership->is_percentage) {
            $membership_discount = $this->subtotal * $membership->discount / 100;
        } else {
            $membership_discount = $membership->discount;
        }

        $this->maxDiscountValue = max($membership_discount, $this->couponPrice);

        $this->setTax($request->address_id);

        $valueAfterApplyCoupon = $this->subtotal + $this->tax - $this->maxDiscountValue;

        $this->grandTotal = round(($valueAfterApplyCoupon <= 0) ? 0 : $valueAfterApplyCoupon, 3);

        $calculate['tax'] = round($this->tax, 3);
        $calculate['coupon_price'] = $this->couponPrice;
        $calculate['grand_total'] = $this->grandTotal;
        $calculate['discount_value'] = $this->maxDiscountValue;
        return $calculate;

    }


    public function checkout(Request $request)
    {

        $this->grandTotal($request);

        $order = $this->model->create([
            'day' => $request->day,
            'slot_id' => $request->slot_id,
            'subtotal' => $this->subtotal,
            'coupon_price' => $this->couponPrice,
            'total' => $this->grandTotal,
            'user_id' => Auth::id(),
            'coupon_id' => ($this->coupon) ? $this->coupon->id : null,
            'order_status_id' => 1,
            'discount' => $this->maxDiscountValue,
            'code' => 1,
            'address_id' => $request->address_id,
            'payment_type_id' => $request->payment_type_id
        ]);

        foreach ($this->carts as $cart) {
            $service_model = ModelServic::findOrFail($cart->service_model_id);
            $model_labour_price = $service_model->labour_price;
            $orderItem = $order->items()->create([
                'service_model_id' => $cart->service_model_id, // will be service_model_id
                'item_cost' => $cart->item_cost,
                'order_item_labour_price' => $model_labour_price
            ]);

            // i want to add service spare part of this service model in Order item service spare parts
            foreach ($service_model->serviceInfoSpareParts as $serviceSparePart) {
                $orderItem->orderItemServiceSpareParts()->create(
                    collect($serviceSparePart)->merge([
                        'order_item' => $orderItem
                    ])->all()
                );
            }

        }
        if ($this->coupon) {
            $this->coupon->users()->attach(Auth::id());
        }
        $user = Auth::user();

        $user->carts()->delete();


        /************************************/

        $data = [
            'msg' => 'a new order ' . $order->code . ' is checked out from: ' . $order->customer->name,
            'to' => "admin,operation",
            'order_id' => $order->id,
        ];

        OrderNotificationHelper::sendNotificationsForOrder($request, $order, $data, 1);


        /****************************************/

        return $order;
    }


}
