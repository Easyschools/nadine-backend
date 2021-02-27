<?php

namespace App\Services\Api\Division;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Repositories\AppRepository;


Class TagApiService extends AppRepository
{

    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
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
    public function createTag($request)
    {
        return $this->model->create($request->only([
            'name_ar','name_en','image',
            'category_id'
        ]));
    }


    /**
     * @param $request
     * @return mixed
     */
    public function editTag($request)
    {
        $tag = $this->find($request->id);
        return $tag->update($request->only([
            'name_ar','name_en','image',
            'category_id'
        ]));
    }



}