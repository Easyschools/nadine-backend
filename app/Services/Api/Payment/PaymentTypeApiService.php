<?php

namespace App\Services\Api\Payment;

use App\Models\Payment\PaymentType;
use App\Repositories\AppRepository;


Class PaymentTypeApiService extends AppRepository
{

    public function __construct(PaymentType $paymentType)
    {
        parent::__construct($paymentType);
    }


    /**
     * @param $request
     * @return mixed
     */
    public function createPaymentType($request)
    {

        return $this->model->create($request->all());
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updatePaymentType($request)
    {
        $paymentType = $this->find($request->id);

        return $paymentType->update($request->all());
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {

        if ($request->is_paginate == 1) {
            return $this->paginate();
        }
        return $this->all();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        return $this->find($request->id);
    }



}
