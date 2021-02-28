<?php

namespace App\Services\Api\Slider;

use App\Models\Slider\Slider;
use App\Repositories\AppRepository;


Class SliderApiService extends AppRepository
{

    public function __construct(Slider $slider)
    {
        parent::__construct($slider);
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
    public function createSlider($request)
    {
        $model = $this->model->create($request->only([
            'name_ar',
            'name_en',
            'text_ar',
            'text_en',
            'image'
        ]));
        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editSlider($request)
    {
        $model = $this->find($request->id);
        $result = $model->update($request->only([
            'name_ar',
            'name_en',
            'text_ar',
            'text_en',
            'image'

        ]));
        return $result;
    }

}
