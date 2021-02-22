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

    public function create(Request $request)
    {
        $request->merge([
            'user_id' => Auth::id()
        ]);
        // delete all carts when Auth customer choose different car model
        foreach ($request->variants as $variant) {
            $this->model->Create([
                'variant_id' => $variant['variant_id'],
                'user_id' => $request->user_id,
                'quantity' => $variant['quantity']
            ]);
        }
        return;
    }
}
