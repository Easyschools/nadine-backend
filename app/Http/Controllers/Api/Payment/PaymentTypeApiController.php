<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Payment;


use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentTypeRequest;
use App\Services\Api\Payment\PaymentTypeApiService;

class PaymentTypeApiController extends Controller
{

    private $paymentTypeService;

    public function __construct(PaymentTypeApiService $paymentTypeService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->paymentTypeService = $paymentTypeService;
    }


    public function create(PaymentTypeRequest $request)
    {

        $process = $this->paymentTypeService ->createPaymentType($request);
        return $this->sendResponse($process);
    }

    public function update(PaymentTypeRequest $request)
    {

        $process = $this->paymentTypeService ->updatePaymentType($request);
        return $this->sendResponse($process);
    }

    public function read(PaymentTypeRequest $request)
    {
        $process = $this->paymentTypeService->get($request);
        return $this->sendResponse($process);
    }


    public function all(PaymentTypeRequest $request)
    {
        $process = $this->paymentTypeService->index($request);
        return $this->sendResponse($process);
    }
}
