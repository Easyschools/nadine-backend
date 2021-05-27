<?php

namespace App\Services\Api\Option;

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
            $colors = $this->paginate();
        } else if ($request->all) {
            $this->setColumns([
                'name_ar',
                'name_en',
                'id',
            ]);

            $colors = $this->paginateQuery()->whereHas('variants')->get();
        } else {
            $colors = $this->all();
        }
        return $colors;
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
    public function createColor($request)
    {
        $category = $this->model->create($request->only([
            'name_ar', 'name_en',
            'image'
        ]));
        return $category;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editColor($request)
    {
        $category = $this->find($request->id);
        $result = $category->update($request->only([
            'name_ar',
            'name_en',
            'image'

        ]));
        return $result;
    }



}
