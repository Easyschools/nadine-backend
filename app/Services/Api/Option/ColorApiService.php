<?php

namespace App\Services\Dashboard\Option;

use App\Models\Option\Color;
use App\Repositories\AppRepository;


Class ColorApiService extends AppRepository
{

    public function __construct(Color $color)
    {
        parent::__construct($color);
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
