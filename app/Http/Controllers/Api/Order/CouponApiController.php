<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CouponRequest;
use App\Services\Api\Order\CouponApiService;

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


    public function read(CouponRequest $request)
    {
        $process = $this->couponApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CouponRequest $request)
    {
        $process = $this->couponApiService->index($request);
        return $this->sendResponse($process);
    }

    public function create(CouponRequest $request)
    {
        $process = $this->couponApiService->createCoupon($request);
        return $this->sendResponse($process);
    }
    public function edit(CouponRequest $request)
    {
        $process = $this->couponApiService->editCoupon($request);
        return $this->sendResponse($process);
    }

    public function delete(CouponRequest $request)
    {
        $process = $this->couponApiService->delete($request->id);
        return $this->sendResponse($process);

    }
}
