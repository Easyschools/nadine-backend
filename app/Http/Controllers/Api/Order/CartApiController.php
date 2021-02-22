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

    public function create(CartRequest $request)
    {
        $this->cartApiService->create($request);
        return $this->sendResponse(true);
    }

    public function delete(CartRequest $request)
    {
        $process = $this->cartApiService->delete($request->id);
        return $this->sendResponse($process);
    }

    public function index(CartRequest $request)
    {
        $this->cartApiService->setConditions(['user_id' => Auth::id()]);
        $this->cartApiService->setRelations(['variant']);
        return $this->sendResponse($this->cartApiService->all());
    }

}
