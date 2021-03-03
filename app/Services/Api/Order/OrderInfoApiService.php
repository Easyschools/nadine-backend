<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 07/12/20
 * Time: 04:21 م
 */

namespace App\Services\Api\Order;


use App\Models\Order\Order;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;

class OrderInfoApiService extends AppRepository
{

    private $order;

    public function __construct()
    {
        $this->order = new AppRepository(new Order());
    }

    public function getUserOrders()
    {
        $this->order->setConditions([['user_id', Auth::id()]]);
        return $this->order->paginate();
    }

    public function orderDetails($orderId)
    {
        $this->order->setRelations([
            'orderItems' => function ($item) {
                $item->with([
                    'variant' => function($variant){
                        $variant->with([
                            'product' => function ($product) {
                                $product->with([
                                    'variants' => function($variantNest1){
                                        $variantNest1->with('color','dimension');
                                    }
                                ]);
                            }
                        ]);
                    }
                ]);
            },
            'address', 'coupon',
            'user'
        ]);
        return $this->order->find($orderId);
    }

    public function allOrders()
    {
        $this->order->setSortBy('id');
        $this->order->setSortOrder('desc');
        $this->order->setRelations([
            'coupon',
            'user',
            'paymentType',
            'address',
            'orderItems',
            'orderStatus'
            ]);
        return $this->order->paginate();
    }

}
