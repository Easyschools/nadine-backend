<?php

namespace App\Services\Api\Order;


use App\Models\Order\Offer;
use App\Repositories\AppRepository;


Class OfferApiService extends AppRepository
{

    public function __construct(Offer $offer)
    {
        parent::__construct($offer);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setRelations([
            'category'
        ]);
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
    public function createOffer($request)
    {
        return $this->model->create($request->only(
            'name_ar',
            'name_en',
            'is_percentage',
            'discount',
            'image',
            'category_id',
            'expire_at'
        ));
    }
    /**
     * @param $request
     * @return mixed
     */
    public function editOffer($request)
    {
        $model = $this->find($request->id);
        $model = $model->update($request->only(
            'name_ar',
            'name_en',
            'is_percentage',
            'discount',
            'image',
            'category_id',
            'expire_at'
        ));

        return $model;
    }


}
