<?php

namespace App\Services\Api\Order;


use App\Models\Order\CustomTagShippingPrice;
use App\Models\Order\Offer;
use App\Models\Order\OrderCustomPriceCustomPrice;
use App\Repositories\AppRepository;


Class CustomTagShippingPriceApiService extends AppRepository
{

    public function __construct(CustomTagShippingPrice $orderCustomPriceCustomPrice)
    {
        parent::__construct($orderCustomPrice);
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
    public function createCustomPrice($request)
    {
        return $this->model->create($request->only(
            'tag_id',
            'cost_inside_cairo',
            'cost_outside_cairo'

        ));
    }
    /**
     * @param $request
     * @return mixed
     */
    public function editCustomPrice($request)
    {
        $model = $this->find($request->id);
        $model = $model->update($request->only(
            'tag_id',
            'cost_inside_cairo',
            'cost_outside_cairo'

        ));

        return $model;
    }



}
