<?php

namespace App\Services\Dashboard\Division;

use App\Models\Division\Category;
use App\Repositories\AppRepository;


Class CategoryApiService extends AppRepository
{

    public function __construct(Category $category)
    {
        parent::__construct($category);
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
        $this->setRelations([
            'tags' => function ($tag) {
                $tag->select('id', 'name_ar', 'name_en', 'category_id');
            },
        ]);
        return $this->find($request->id);
    }


}
