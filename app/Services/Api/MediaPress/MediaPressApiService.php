<?php

namespace App\Services\Api\MediaPress;

use App\Models\MediaPress\MediaPress;
use App\Repositories\AppRepository;


Class MediaPressApiService extends AppRepository
{

    public function __construct(MediaPress $mediaPress)
    {
        parent::__construct($mediaPress);
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
    public function createMediaPress($request)
    {
        $model = $this->model->create($request->only([
            'name_ar',
            'name_en',
            'image'
            'url',
        ]));
        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editMediaPress($request)
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
