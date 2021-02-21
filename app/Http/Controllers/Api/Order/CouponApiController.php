<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Order;


use App\Http\Controllers\Controller;
use App\Services\Dashboard\Order\CouponApiService;

class CouponApiController extends Controller
{

    private $couponApiService;

    public function __construct(CouponApiService $couponApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->couponApiService = $couponApiService;
    }


    public function read(\App\Http\Requests\Order\CouponRequest $request)
    {
        $process = $this->couponApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(\App\Http\Requests\Order\CouponRequest $request)
    {
        $process = $this->couponApiService->index($request);
        return $this->sendResponse($process);
    }
}
