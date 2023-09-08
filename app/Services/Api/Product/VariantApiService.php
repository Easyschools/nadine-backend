<?php

namespace App\Services\Api\Product;

use App\Models\Option\Color;
use App\Models\Product\Product;
use App\Models\Product\Variant;
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
        $this->setRelations([
            'color',
            'dimension',
        ]);
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
        $this->setRelations([
            'color',
            'dimension',
        ]);
        return $this->find($request->id);
    }



}
