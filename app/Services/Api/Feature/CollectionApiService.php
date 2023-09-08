<?php

namespace App\Services\Api\Feature;


use App\Models\Feature\Collection;
use App\Repositories\AppRepository;


Class CollectionApiService extends AppRepository
{

    public function __construct(Collection $collection)
    {
        parent::__construct($collection);
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
            'products' => function ($product) {
                $product->with([
                    'variants' => function ($variant) {
                        $variant->with([
                            'color',
                            'dimension',
                        ]);
                    }
                ]);
            }
        ]);
        return $this->find($request->id);
    }



    /**
     * @param $request
     * @return mixed
     */
    public function createCollection($request)
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
    public function editCollection($request)
    {
        $material = $this->find($request->id);

        return $material->update($request->only([
            'name_en',
            'name_ar',
        ]));
    }


}
