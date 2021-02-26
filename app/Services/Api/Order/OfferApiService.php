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
