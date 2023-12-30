<?php

namespace App\Services\Api\Celebrity;

use App\Models\Celebrity\Celebrity;
use App\Repositories\AppRepository;


Class CelebrityApiService extends AppRepository
{

    public function __construct(Celebrity $celebrity)
    {
        parent::__construct($celebrity);
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
    public function createCelebrity($request)
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
    public function editCelebrity($request)
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
