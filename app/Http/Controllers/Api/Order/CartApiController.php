<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CartRequest;
use App\Services\Api\Order\CartApiService;
use Illuminate\Support\Facades\Auth;
use App\Models\Order\Cart;

class CartApiController extends Controller
{
    private $cartApiService;

    public function __construct(CartApiService $cartApiService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:2')
            ->only(['create', 'delete']);
        $this->cartApiService = $cartApiService;
    }

    public function addToCart(CartRequest $request)
    {
        $process = $this->cartApiService->addToCart($request);
        return $this->sendResponse($process);
    }


    public function delete(CartRequest $request)
    {
        $process = $this->cartApiService->delete($request->id);
        return $this->sendResponse($process);
    }


    public function update(CartRequest $request)
    {
        $process = $this->cartApiService->updateCart($request);
        return $this->sendResponse($process);
    }

    public function index(CartRequest $request)
    {
        $process = $this->cartApiService->index($request);
        return $this->sendResponse($process);
    }

}
