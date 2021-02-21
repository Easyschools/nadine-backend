<?php

namespace App\Services\Dashboard\Product;

use App\Models\Option\Color;
use App\Product\Product;
use App\Product\Variant;
use App\Repositories\AppRepository;


Class VariantApiService extends AppRepository
{

    public function __construct(Variant $variant)
    {
        parent::__construct($variant);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {

        $this->setConditions([
            ['product_id',$request->product_id]
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
        return $this->find($request->id);
    }



}
