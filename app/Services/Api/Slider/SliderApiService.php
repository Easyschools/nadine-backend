<?php

namespace App\Services\Dashboard\Slider;

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



}
