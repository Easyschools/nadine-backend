<?php

namespace App\Services\Api\Division;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Order\CustomTagShippingPrice;
use App\Repositories\AppRepository;
use App\Services\Api\Order\CustomTagShippingPriceApiService;

class TagApiService extends AppRepository
{
    private $customTagShippingPriceApiService;

    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
        $this->customTagShippingPriceApiService = new  AppRepository(new CustomTagShippingPrice);
    }
    /**
     * @param $request
     * @return mixed
     */
    // public function index($request)
    // {
    //     $this->filter($request);

    //     $this->setRelations([
    //         'category',
    //         'customTagShippingPrice'
    //     ]);

    //     if ($request->is_paginate == 1) {
    //         return $this->paginate();
    //     }
    //     return $this->all()->count();
    // }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $this->setRelations([
            'category',
            'customTagShippingPrice:id,tag_id,cost_inside_cairo,cost_outside_cairo'
        ]);
        return $this->find($request->id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createTag($request)
    {
        $tag = $this->model->create(
            [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'slug' => \Illuminate\Support\Str::slug($request->name_en),
                'image' => $request->image,
                'category_id' => $request->category_id,
            ]
        );
        // if ($request->cost_inside_cairo || $request->cost_outside_cairo) {
        //     $this->customTagShippingPriceApiService->model->create([
        //         'tag_id' => $tag->id,
        //         'cost_inside_cairo' => $request->cost_inside_cairo,
        //         'cost_outside_cairo' => $request->cost_outside_cairo,
        //     ]);
        // }
        return $tag;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function editTag($request)
    {
        $tag = $this->find($request->id);
        if ($tag->customTagShippingPrice) {
            $tag->customTagShippingPrice->update([
                'cost_inside_cairo' => $request->cost_inside_cairo,
                'cost_outside_cairo' => $request->cost_outside_cairo,
            ]);
        }
        return $tag->update([
            'name_ar' => $request->name_ar ?? $tag->name_ar,
            'name_en' => $request->name_en ?? $tag->name_en,
            'slug' => $request->name_en ? \Illuminate\Support\Str::slug($request->name_en) : $tag->slug,
            'image' => $request->image ?? $tag->image,
            'category_id' => $request->category_id ?? $tag->category_id,
        ]);
    }


    public function filter($request)
    {
        $conditions = [];

        if ($request->category_id) {
            $conditions[] = ['category_id', $request->category_id];
        }

        $this->setConditions($conditions);
    }
}
