<?php

namespace App\Services\Dashboard\Region;

use App\Models\Region\City;
use App\Repositories\AppRepository;


Class CityApiService extends AppRepository
{

    public function __construct(City $city)
    {
        parent::__construct($city);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setRelations(['country']);
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
