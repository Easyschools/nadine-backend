<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CustomTagShippingPriceRequest;
use App\Services\Api\Order\CustomTagShippingPriceApiService;

class CustomTagShippingPriceApiController extends Controller
{

    private $customeShippingPriceApiService;

    public function __construct(CustomTagShippingPriceApiService $customeShippingPriceApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->customeShippingPriceApiService = $customeShippingPriceApiService;
    }


    public function read(CustomTagShippingPriceRequest $request)
    {
        $process = $this->customeShippingPriceApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CustomTagShippingPriceRequest $request)
    {
        $process = $this->customeShippingPriceApiService->index($request);
        return $this->sendResponse($process);
    }

    public function create(CustomTagShippingPriceRequest $request)
    {
        $process = $this->customeShippingPriceApiService->createCustomPrice($request);
        return $this->sendResponse($process);
    }

    public function edit(CustomTagShippingPriceRequest $request)
    {
        $process = $this->customeShippingPriceApiService->editCustomPrice($request);
        return $this->sendResponse($process);
    }
    public function delete(CustomTagShippingPriceRequest $request)
    {
        $process = $this->customeShippingPriceApiService->delete($request->id);
        return $this->sendResponse($process);
    }
}
