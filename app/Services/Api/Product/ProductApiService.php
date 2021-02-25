<?php

namespace App\Services\Dashboard\Product;

use App\Models\Option\Color;
use App\Product\Product;
use App\Repositories\AppRepository;


Class ProductApiService extends AppRepository
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $this->setRelations([
            'variants',
            'tag',
            'category'
        ]);

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
            'variants',
            'tag',
            'category'
        ]);
        return $this->find($request->id);
    }


}
