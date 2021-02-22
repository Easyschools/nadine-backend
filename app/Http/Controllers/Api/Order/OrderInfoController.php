<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 07/12/20
 * Time: 04:18 م
 */

namespace App\Http\Controllers\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Services\Order\OrderInfoِApiService;
use Illuminate\Http\Request;
use  PDF;
use Illuminate\Support\Facades\Storage;


class OrderInfoController extends Controller
{
    private $orderService;

    public function __construct(OrderInfoِApiService $orderService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1,2')
            ->only(['statusStatistics', 'confirmSlots']);
        $this->middleware('check.role:4')
            ->only('getUserOrders');
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $process = $this->orderService->index($request);
        return $this->sendResponse($process);
    }

    public function customerOrders(Request $request)
    {
        $process = $this->orderService->getOrdersForComplains($request);
        return $this->sendResponse($process);
    }

    public function orderDetails(OrderRequest $request)
    {
        $process = $this->orderService->get($request->id);
        return $this->sendResponse($process);
    }

    public function getUserOrders(OrderRequest $request)
    {
        $process = $this->orderService->getUserOrders($request);
        return $this->sendResponse($process);
    }

    public function statusStatistics()
    {
        $process = $this->orderService->statusStatistics();
        return $this->sendResponse($process);
    }

    public function filter(OrderRequest $request)
    {

        $process = $this->orderService->filter($request);
//        dd($process['grand_total']);
        return $this->sendResponse($process);

    }



    public function getSlots(OrderRequest $request)
    {
        $process = $this->orderService->getSlots($request);
        return $this->sendResponse($process);
    }

    public function confirmSlots(OrderRequest $request)
    {
        $process = $this->orderService->confirmSlots($request);
        return $this->sendResponse($process);
    }
}
