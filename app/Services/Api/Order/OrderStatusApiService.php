<?php

namespace App\Services\Dashboard\Order;


use App\Models\Order\Offer;
use App\Models\Order\OrderStatus;
use App\Repositories\AppRepository;


Class OrderStatusApiService extends AppRepository
{

    public function __construct(OrderStatus $orderStatus)
    {
        parent::__construct($orderStatus);
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
