<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OfferRequest;
use App\Services\Dashboard\Order\OfferApiService;
use App\Services\Dashboard\Order\OrderStatusApiService;

class OrderStatusApiController extends Controller
{

    private $orderStatusApiService;

    public function __construct(OrderStatusApiService $orderStatusApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->orderStatusApiService = $orderStatusApiService;
    }


    public function read(OfferRequest $request)
    {
        $process = $this->orderStatusApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(OfferRequest $request)
    {
        $process = $this->orderStatusApiService->index($request);
        return $this->sendResponse($process);
    }
}
