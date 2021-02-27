<?php

namespace App\Services\Api\Product;

use App\Models\Option\Color;
use App\Models\Product\Product;
use App\Models\Product\Variant;
use App\Repositories\AppRepository;


class ProductApiService extends AppRepository
{

    private $variantRepo;

    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->variantRepo = new AppRepository(new Variant());
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

    /**
     * @param $request
     * @return mixed
     */
    public function createProduct($request)
    {
//        dd($request->all());
        $product = Product::create($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'weight',
            'price',
            'collection_id',
            'category_id',
            'tag_id',
            'material_id',
            'tag_id',
        ]));

        foreach ($request->variants as $variant) {
            Variant::create(array_merge($variant, [
                'product_id' => $product->id
            ]));
        }

        return $product;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateProduct($request)
    {
        $product = $this->find($request->id);

        $product->update($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'slug',
            'stock',
            'weight',
            'price',
            'collection_id',
            'category_id',
            'tag_id',
            'material_id',
            'tag_id',
        ]));

        $oldVariantsIds = $product->variants()->pluck('id')->toArray();
        $arr = [];
//        dd($request->variants);
        foreach ($request->variants as $variant) {

            if ($variant['id']) {

                $variantModel = $this->variantRepo->find($variant['id']);
                $variantModel->update($variant);

                $arr[] = $variant['id'];

            } else {
                Variant::create(array_merge($variant, [
                    'product_id' => $product->id
                ]));
            }
        }

        //delete variants
        $deletedIds = array_diff($oldVariantsIds, $arr);
        $this->variantRepo->model->whereIn('id', $deletedIds)->delete();

        return $product;
    }


}
