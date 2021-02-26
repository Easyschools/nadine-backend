<?php

namespace App\Services\Api\Option;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Repositories\AppRepository;


Class DimensionApiService extends AppRepository
{

    public function __construct(Dimension $dimension)
    {
        parent::__construct($dimension);
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
