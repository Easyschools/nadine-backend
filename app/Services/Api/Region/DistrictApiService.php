<?php

namespace App\Services\Api\Region;


use App\Models\Region\District;
use App\Repositories\AppRepository;


Class DistrictApiService extends AppRepository
{

    public function __construct(District $district)
    {
        parent::__construct($district);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setRelations(['city']);
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
        $this->setRelations(['city']);

        return $this->find($request->id);
    }



}
