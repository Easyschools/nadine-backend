<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Services\Order\OrderApiService;

class OrderApiController extends Controller
{
    public $orderService;

    public function __construct(OrderApiService $orderService)
    {
        $this->middleware(['auth:api']);
//        $this->middleware('check.role:2,1')
//            ->only('assignTechnician');
        $this->orderService = $orderService;
    }

    public function calculate($request)
    {
        $process = $this->orderService->calculate($request);
        return $this->sendResponse($process);
    }

    public function grandTotal(OrderRequest $request)
    {
        $process = $this->orderService->grandTotal($request);
        return $this->sendResponse($process);
    }

    public function checkout(OrderRequest $request)
    {
        $process = $this->orderService->checkout($request);
        return $this->sendResponse($process);
    }


}
