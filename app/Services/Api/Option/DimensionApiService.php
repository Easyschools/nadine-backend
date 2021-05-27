<?php

namespace App\Services\Api\Option;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Auth;


class DimensionApiService extends AppRepository
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
            $dimensions = $this->paginate();
        } else if ($request->all) {
            $this->setColumns([
                'dimension',
                'id',
            ]);
            $dimensions = $this->paginateQuery()->whereHas('variants')->get();
        } else {
            $dimensions = $this->all();
        }

        return $dimensions;
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
    public function createDimension($request)
    {
        return $this->model->firstOrCreate($request->only([
            'dimension',
        ]));
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editDimension($request)
    {
        $material = $this->find($request->id);

        return $material->update($request->only([
            'dimension',
        ]));
    }


}
