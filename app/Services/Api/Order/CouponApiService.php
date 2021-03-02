<?php

namespace App\Services\Api\Order;

use App\Models\Option\Material;
use App\Models\Order\Coupon;
use App\Repositories\AppRepository;


Class CouponApiService extends AppRepository
{

    public function __construct(Coupon $coupon)
    {
        parent::__construct($coupon);
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

    /**
     * @param $request
     * @return mixed
     */
    public function createCoupon($request)
    {
        $model = $this->model->create($request->only(
            'code', 'is_percentage',
            'max_usage',
            'value', 'all_users'
            , 'users'
            , 'min_total'
        ));

        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editCoupon($request)
    {

        $model = $this->find($request->id);
        $model->update($request->only(
            'code',
            'is_percentage',
            'max_usage',
            'value',
            'all_users'
            , 'users'
            , 'min_total'
        ));

        return $model;
    }


}
