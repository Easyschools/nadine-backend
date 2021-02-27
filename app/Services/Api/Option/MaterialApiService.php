<?php

namespace App\Services\Api\Option;

use App\Models\Option\Material;
use App\Repositories\AppRepository;


Class MaterialApiService extends AppRepository
{

    public function __construct(Material $material)
    {
        parent::__construct($material);
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
    public function createMaterial($request)
    {
        return $this->model->create($request->only([
            'name_en',
            'name_ar',
        ]));
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editMaterial($request)
    {
        $material = $this->find($request->id);
        return $material->update($request->only([
            'name_en',
            'name_ar',
        ]));
    }



}
