<?php

namespace App\Services\Api\Feature;


use App\Models\Feature\Collection;
use App\Repositories\AppRepository;


class CollectionApiService extends AppRepository
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
        return $this->model->create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => \Illuminate\Support\Str::slug($request->name_en),
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editCollection($request)
    {
        $collection = $this->find($request->id);

        return $collection->update(
            [
                'name_ar' => $request->name_ar ?? $collection->name_ar,
                'name_en' => $request->name_en ?? $collection->name_en,
                'slug' => $request->name_en ? \Illuminate\Support\Str::slug($request->name_en) : $collection->slug,
            ]
        );
    }
}
