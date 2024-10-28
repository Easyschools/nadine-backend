<?php

/**
 * Created by PhpStorm.
 * User: amir
 * Date: 29/11/20
 * Time: 05:36 م
 */

namespace App\Services\Api\Order;

use App\ThirdParty\Pixel;
use App\Models\Order\Cart;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;

class CartApiService extends AppRepository
{
    public function __construct(Cart $cart)
    {
        parent::__construct($cart);
    }

    public function index($request)
    {
        $this->setConditions([['user_id', Auth::id()]]);

        $this->setRelations([
            'variant' => function ($variant) {
                $variant->select(
                    'id',
                    'product_id',
                    'color_id',
                    'dimension_id',
                    'additional_price'
                )->with([
                    'product' => function ($product) {
                        $product->select(
                            'id',
                            'name_ar',
                            'name_en',
                            'slug',
                            'price_after_discount',
                            'tag_id',
                            'price'
                        );
                    },
                    'color' => function ($color) {
                        $color->select(
                            'id',
                            'name_ar',
                            'name_en',
                            'image'
                        );
                    },
                    'dimension' => function ($dimension) {
                        $dimension->select(
                            'id',
                            'dimension'
                        );
                    },
                ]);
            },
        ]);

        return $this->all();
    }

    public function addToCart($request)
    {
        Pixel::addToCart();
        $request->merge([
            'user_id' => Auth::id(),
        ]);

        if ($request->has('variants') && count($request->variants)) {

            foreach ($request->variants as $variant) {
                $this->model->create([
                    'variant_id' => $variant['variantId'],
                    'user_id' => $request->user_id,
                    'quantity' => $variant['qty'],
                    'dimension_id' => $request->dimension_id?? null,
                    'color_id' => $request->color_id ?? null,
                    'material_id' => $request->material_id ?? null,
                ]);
            }
        } else {
            $this->model->create([
                'variant_id' => $request['variantId'],
                'user_id' => $request->user_id,
                'quantity' => $request['qty'],
                'dimension_id' => $request->dimension_id?? null,
                'color_id' => $request->color_id ?? null,
                'material_id' => $request->material_id ?? null,
            ]);
        }
        return true;
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
