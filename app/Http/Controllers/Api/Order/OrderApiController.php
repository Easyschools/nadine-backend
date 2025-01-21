<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Services\Api\Order\OrderApiService;
use App\Services\Api\Payment\PaymobOrderService;
use Illuminate\Support\Facades\DB;

class OrderApiController extends Controller
{
    private $orderApiService;
    private $paymobOrderService;


    public function __construct(OrderApiService $orderApiService,  PaymobOrderService $paymobOrderService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1')
            ->only('updateStatus');
        // $this->middleware('check.role:2')
        //     ->only('updateStatus', 'grandTotal', 'checkout');
        // $this->middleware('auth:api')->only('checkout');
        // $this->middleware('auth:web')
        //     ->only('checkout');

        $this->orderApiService = $orderApiService;
        $this->paymobOrderService = $paymobOrderService;
    }

    public function calculate()
    {
        $process = $this->orderApiService->calculate();
        return $this->sendResponse($process);
    }

    //update status
    public function updateStatus(OrderRequest $request)
    {
        $process = $this->orderApiService->updateStatus($request, $request->id);
        return $this->sendResponse($process);
    }

    public function grandTotal(OrderRequest $request)
    {
        $process = $this->orderApiService->grandTotal($request);
        if ($process == false) {
            return $this->sendError($process, 'please, add product to cart');
        }if (!is_array($process)) {
            return $this->sendError($process, 'please use a valid coupon or ' . $process);
        }
        return $this->sendResponse($process);
    }

    public function checkout(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderApiService->checkout($request);
            if (!$order) {
                return $this->sendError('Failed to create order');
            }
            if ($request->payment_type_id === 2 || $request->payment_type_id === 3)
            {
                $paymentUrl = $this->paymobOrderService->processPayment($order);
                DB::commit();
                return $this->sendResponse([
                    'order'       => $order,
                    'payment_url' => $paymentUrl
                ]);
            }

            DB::commit();
            return $this->sendResponse($order);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function delete(OrderRequest $request)
    {
        $process = $this->orderApiService->deleteOrder($request->order_id);
        if (!$process) {
            return $this->sendError($process);
        }
        return $this->sendResponse($process);
    }

}
