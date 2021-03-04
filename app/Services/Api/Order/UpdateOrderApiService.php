<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 08/12/20
 * Time: 02:53 م
 */

namespace App\Services\Api\Order;

use App\Models\Order\Coupon;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Product\Variant;
use App\Models\User\Address;
use App\Models\User\User;
use App\Repositories\AppRepository;
use App\Traits\FirebaseFCM;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpdateOrderApiService extends AppRepository
{
    use FirebaseFCM;

    private $order;
    private $coupon = null;
    private $variantService = null;
    private $couponValue = 0;
    private $shipping;
    private $address;
    private $subtotal = 0;
    private $discount = 0;
    private $offerDiscount = 0;
    private $shippingPrice = 30;
    private $orderStatus = 1;
    private $quantity = 0;
    private $description = '';
    private $user_id = 0;
    private $items = [];

    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->variantService = new AppRepository(new Variant());
    }

    public function setAddress($id)
    {
        $this->address = (new AppRepository(new Address()))->find($id);

    }

    public function setShippingPrice()
    {
        if ($this->address->id == 1) {
            $this->shippingPrice = 200;
        }
        $this->shippingPrice = 250;

    }

    public function setOrderStatus()
    {
        $this->orderStatus = 1;
    }

    /**
     * @param $item
     * @return float|int
     */
    public function getOfferPrice($item)
    {
//        dd($item->variant->product->category->offers()->first()->expire_at);
//        dd($item['variant']);
        $offer = $item->product->category->offers()->first()
            ->where('expire_at', '>=', Carbon::now()->toDateTimeString())->first();
        $productPrice = $item->product->price + $item->additional_price;

        $offerItemPrice = -1;

        if ($offer) {
            if ($offer->is_percentage) {
                $offerItemPrice = $productPrice - ($offer->discount * $productPrice / 100);

            } else {
                $offerItemPrice = $productPrice - $offer->discount;

            }
        }

        // check if it became negative number
        if ($offerItemPrice < 0) {
            $offerItemPrice = 0;
        }

        return $offerItemPrice;
    }


    public function setItems(Request $request)
    {
        $orderItems = [];
        foreach ($request->order_items as $order_item) {
            if (array_key_exists('variant',$order_item['variant']['product'])) {
                $orderItems[] = $order_item['variant'];
            } else {
                $variant = $this->variantService->model->with([
                    'product' => function ($product) {
                        $product->select('id', 'price', 'name_en', 'name_ar', 'tag_id',
                            'category_id')
                            ->with([
                                'category' => function ($category) {
                                    $category->select('id', 'name_ar', 'name_en')->with([
                                        'offers' => function ($offer) {
                                            $offer->select('id', 'is_percentage', 'discount',
                                                'category_id');
                                        }
                                    ]);
                                }
                            ]);
                    }
                ])->where('id', $order_item['variant_id'])->first();
                $variant['quantity'] = $order_item['quantity'];
                $orderItems[] = $variant;
            }
        }
//        unset($request['order_items']);
//        dd($orderItems[0]);
        $this->items = $orderItems;
    }

    /**
     * calculate
     * @return array
     */
    public function calculate($request)
    {
        $this->order->orderItems()->delete();

        $this->setItems($request);



        foreach ($this->items as $item) {

//            $variantProduct = $item['variant']['product']['product'];
            $offerItemPrice = $this->getOfferPrice($item);

            $itemPrice = ($offerItemPrice >= 0 ? $offerItemPrice : $item['variant']->product->price);

            $item['total_item_price'] = $item->quantity * $itemPrice;

            $item['item_price'] = $itemPrice;

            $this->subtotal += $item['total_item_price'];

            $this->quantity += $item->quantity;
        }

        return [
            'total_quantity' => $this->quantity,
            'subtotal' => $this->subtotal,
            'items' => $this->items,
        ];
    }

    /**
     * calculate grand total
     * @param Request $request
     * @return array
     */
    public function grandTotal(Request $request)
    {
        $this->calculate($request);

        if (count($this->items) == 0) {
            return false;
        }
//        $this->couponValue($request->code, $this->subtotal);

        $this->setAddress($request->address_id);

        $this->setShippingPrice();

        $this->setOrderStatus();

//        $extraFees = ($request->payment_method == 'cash') ? 20 : 0;
        return [
            'subtotal' => $this->subtotal,
            'user_id' => Auth::id(),
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus,
            'total_quantity' => $this->quantity,
            'coupon_id' => ($this->coupon) ? $this->coupon->id : null,
            'coupon_price' => $this->couponValue,
            'grand_total' => $this->shippingPrice + $this->subtotal - $this->couponValue,
            'shipping_price' => $this->shippingPrice,
            'items' => $this->items,
        ];
    }

    /**
     * get coupon value
     * @param string|null $code
     * @param float|int $subtotal
     * @return array
     */
    private function couponValue(string $code = null, float $subtotal = 0)
    {
        $this->coupon = Coupon::where('code', $code)
            ->whereColumn('max_usage', '>', 'used_times')
            ->first();

        if ($this->coupon) {
            if ($this->coupon->all_users == 1 || in_array(Auth::id(), $this->coupon->users)) {
                $this->couponValue = ($this->coupon->is_percentage == 0) ? $this->coupon->value :
                    $subtotal * ($this->coupon->value / 100);
                $this->coupon->update([
                    'used_times' => $this->coupon->used_times + 1,
                ]);
            }
        }

        return [
            'value' => $this->couponValue,
            'coupon_id' => ($this->coupon) ? $this->coupon->id : null,
        ];
    }

    public function updateOrder(Request $request)
    {
        $this->order = $this->find($request->id);

        $grandTotal = $this->grandTotal($request);

        if (count($this->items) == 0) {
            return false;
        }
        $this->order->update([
            'order_quantity' => $this->quantity,
            'order_status_id' => $request->order_status_id,
            'subtotal' => $this->subtotal,
//            'coupon_price' => $this->couponValue,
//            'coupon_id' => ($this->coupon) ? $this->coupon->id : null,
            'grand_total' => $grandTotal['grand_total'],
            'address_id' => $this->address->id,
            'shipping_price' => $this->shippingPrice,
            'payment_type_id' => $request->payment_type_id,
            'notes' => $request->notes
        ]);

        $this->addOrderItems($this->items);

        if ($this->coupon) {
            $this->coupon->user()->attach(Auth::id());
            $this->coupon->update([
                'used_times' => $this->coupon->used_times + 1
            ]);
        }
//        $this->createWaybill($this->address, $this->order, $this->description);
//        Cart::where('user_id', Auth::id())
//            ->delete();
        return $this->order;
    }

    public function storePaymentData($order, Request $request)
    {
        return $order->payment()->create($request->only(
            'Amount', 'Currency', 'MerchantReference', 'NetworkReference', 'PaidThrough', 'PayerAccount', 'PayerName', 'ProviderSchemeName', 'SecureHash', 'SystemReference', 'TxnDate'
        ));
    }

    /**
     * add items to order
     * @param $orderItems
     */
    private function addOrderItems($orderItems)
    {
        foreach ($orderItems as $item) {
//            dd($item->toArray());

            $this->order->orderItems()->create([
                'variant_id' => $item->id,
                'offer_id' => $item->product->category->offer_id,
                'item_price' => $item->item_price,
                'quantity' => $item->quantity,
                'total_item_price' => $item->total_item_price,
            ]);
        }
    }


    /**
     * delete order order
     * @param $orderId
     * @return mixed
     */
    public function deleteOrder($orderId)
    {
        OrderItem::where('order_id', $orderId)->delete();
        return Order::find($orderId)->delete();
    }


}
