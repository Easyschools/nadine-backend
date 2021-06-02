<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 29/11/20
 * Time: 05:36 م
 */

namespace App\Services\Api\Order;


use App\Models\Order\Cart;
use App\Repositories\AppRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartApiService extends AppRepository
{
    public function __construct(Cart $cart)
    {
        parent::__construct($cart);
    }


    public function index()
    {
        $this->setConditions([['user_id', Auth::id()]]);

        $this->setRelations([
            'variant' => function ($variant) {
                $variant->select('id', 'product_id', 'dimension_id',
                    'additional_price')->with([
                    'product' => function ($product) {
                        $product->select('id', 'name_ar', 'name_en','slug' ,
                            'price_after_discount'
                        );
                    }
                ]);
            }
        ]);

        return $this->all();
    }


    public function addToCart($request)
    {
        $request->merge([
            'user_id' => Auth::id()
        ]);

        $cart = $this->model->where('user_id', Auth::id())
            ->where('variant_id', $request->variant_id)
            ->first();


        if ($cart) {
            return $this->update($cart->id, [
                'quantity' => $cart->quantity + 1
            ]);
        }

        return $this->model->create([
            'variant_id' => $request['variant_id'],
            'user_id' => $request->user_id,
            'quantity' => $request['quantity']
        ]);

    }


    public function updateCart($request)
    {
        return $this->update($request->cart_id, $request->only(
            'quantity'
        ));
    }

    public function deleteFromCart($request)
    {
        return $this->model->delete($request->cart_id);
    }


}
