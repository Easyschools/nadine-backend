<?php

namespace App\Services\Api\Feature;

use App\Models\Feature\Brand;
use App\Models\Feature\City;
use App\Repositories\AppRepository;


Class BrandApiService extends AppRepository
{

    public function __construct(Brand $brand)
    {
         parent::__construct($brand);
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
    public function createBrand($request)
    {
        $model = $this->model->create($request->only([
            'name_ar',
            'name_en',
            'image'
        ]));
        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editBrand($request)
    {
        $model = $this->find($request->id);
        $result = $model->update($request->only([
            'name_ar',
            'name_en',
            'image'

        ]));
        return $result;
    }




}
