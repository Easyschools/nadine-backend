<?php

namespace App\Services\Dashboard\Region;

use App\Models\Region\Country;
use App\Repositories\AppRepository;


Class CountryApiService extends AppRepository
{

    public function __construct(Country $country)
    {
        parent::__construct($country);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setRelations(['cities']);
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
