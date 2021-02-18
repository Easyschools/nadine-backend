<?php

namespace App\Services\Dashboard;

use App\Models\Category\Category;
use App\Repositories\AppRepository;


Class CategoryApiService extends AppRepository
{

    public function __construct(Category $categry)
    {
        parent::__construct($categry);
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
