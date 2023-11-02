<?php

namespace App\Services\Api\Division;

use App\Models\Division\Category;
use App\Repositories\AppRepository;

class CategoryApiService extends AppRepository
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
        $this->setColumns(['id', 'name_ar', 'name_en', 'slug']);
        $this->setRelations([
            'tags' => function ($tag) {
                $tag->select('id', 'name_ar', 'name_en', 'slug', 'category_id');
            }
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
            'tags' => function ($tag) {
                $tag->select('id', 'name_ar', 'name_en', 'slug', 'category_id');
            },
        ]);
        return $this->find($request->id);
    }

    public function getProducts($request)
    {
        $this->setRelations(['products:products.id,products.slug,products.name_en,products.name_ar,products.price,products.price_after_discount,sku']);
        return $this->find($request->id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createCategory($request)
    {
        $category = $this->model->create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'slug' => \Illuminate\Support\Str::slug($request->name_en),
        ]);
        return $category;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editCategory($request)
    {
        $category = $this->find($request->id);
        $result = $category->update(
            [
                'name_ar' => $request->name_ar ?? $category->name_ar,
                'name_en' => $request->name_en ?? $category->name_en,
                'slug' => $request->name_en ? \Illuminate\Support\Str::slug($request->name_en) : $category->slug,
            ]
        );
        return $result;
    }
}
