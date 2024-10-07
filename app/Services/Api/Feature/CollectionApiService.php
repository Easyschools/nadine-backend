<?php

namespace App\Services\Api\Feature;

use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Repositories\AppRepository;


class CollectionApiService extends AppRepository
{
    public $sortKey;
    public $tags;

    public function __construct(Collection $collection)
    {
        parent::__construct($collection);
    }

    /**
     * @param $request
     * @return mixed
     */
    // public function index($request)
    // {

    //     if ($request->is_paginate == 1) {
    //         return $this->paginate();
    //     }
    //     return $this->all();
    // }
    public function index($request)
{
    // Check if pagination is required
    if ($request->is_paginate == 1) {
        return $this->setRelations([
            'products' => function ($productQuery) use ($request) {
                // Eager load relations for products with their variants and images
                $productQuery->with([
                    'images',
                    'variants' => function ($variant) {
                        $variant->with([
                            'color',
                            'dimension',
                            'material',
                            'ColorVariant',
                            'DimensionVariant',
                        ]);
                    }
                ]);
            }
        ])->paginate();
    }

    // Return all results without pagination
    return $this->setRelations([
        'products' => function ($productQuery) use ($request) {
            // Eager load relations for products with their variants and images
            $productQuery->with([
                'images',
                'variants' => function ($variant) {
                    $variant->with([
                        'color',
                        'dimension',
                        'material',
                        'ColorVariant',
                        'DimensionVariant',
                    ]);
                }
            ]);
        }
    ])->get();
}


    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $tagIds = [];
        $categoryTagsIds = [];

        if ($request->tag) {
            $tagNames = $this->replaceDashWithSpace(explode(',', $request->tag));

            foreach ($tagNames as $tagName) {
                $tagIds = array_merge($tagIds, Tag::where('name_ar', $tagName)->orWhere('name_en', $tagName)->pluck('id')->toArray());
            }
        }

        if ($request->category) {
            if ($request->category == 'discounts') {
                $categoryTagsIds = $this->getDiscountCategoryTagIds();
            } else {
                $categoryTags = $this->replaceDashWithSpace(explode(',', $request->category));

                foreach ($categoryTags as $categoryTag) {
                    $categoryTagsIds = array_merge($categoryTagsIds, Tag::whereHas('category', function ($q) use ($categoryTag) {
                        $q->where('name_en', 'like', '%' . $categoryTag . '%')->orWhere('name_ar', 'like', '%' . $categoryTag . '%');
                    })->pluck('id')->toArray());
                }
            }
        }

        $this->tags = isset($tagIds) ? $tagIds : [];

        $this->sortKey = $request->input('sort_by', 'created_at');

        $productQuery = $this->paginateQuery();

        $this->setRelations([
            // 'products' => function ($productQuery) use ($request, $categoryTagsIds) {
            //     $productQuery->with([
            //         'variants' => function ($variant) {
            //             $variant->with([
            //                 // 'color',
            //                 // 'dimension',
            //                 'color', 'dimension', 'material', 'ColorVariant', 'DimensionVariant',

            //             ]);
            //         }
            //     ]);
            'products' => function ($productQuery) use ($request, $categoryTagsIds) {
                $productQuery->with([
                    'images',
                    'variants' => function ($variant) {
                        $variant->with([
                            // 'color',
                            // 'dimension',
                            'color', 'dimension', 'material', 'ColorVariant', 'DimensionVariant',

                        ]);
                    }
                ]);

                // Filter by tags if 'tag' parameter is present
                if ($request->tag) {
                    $productQuery->whereIn('tag_id', $this->tags);
                }

                // Filter by occasional material
                if ($request->occasional) {
                    $productQuery->whereHas('material', function ($q) use ($request) {
                        $q->where('id', $request->occasional);
                    });
                }

                // Filter by category tags
                if ($request->category) {
                    $productQuery->whereIn('tag_id', $categoryTagsIds);
                }

                // Filter by discounts
                if ($request->category == 'discounts') {
                    $productQuery->whereHas('offer')->orWhere('price_after_discount', '!=', 0);
                }

                $productQuery->orderBy($this->sortKey, 'desc');
            }
        ]);

        return $this->find($request->id);
    }
    // public function get($request)
    // {
    //     if ($request->tag) {
    //         $tag = $request->tag;
    //         $tag = explode(',', $tag);
    //         $tag_names = $this->replaceDashWithSpace($tag);

    //         $tag_ids = [];

    //         foreach ($tag_names as $tag_name) {
    //             $arr = Tag::where('name_ar', $tag_name)->orWhere('name_en', $tag_name)->pluck('id')->toArray();
    //             $tag_ids = array_merge($tag_ids, $arr);
    //         }
    //     }

    //     $this->tags = isset($tag_ids) ? $tag_ids : [];
    //     // dd($this->tags);

    //     $this->sortKey = request()->input('sort_by', 'created_at');
    //     $this->setRelations([
    //         'products' => function ($product) use ($request) {
    //             $product->with([
    //                 'variants' => function ($variant) {
    //                     $variant->with([
    //                         'color',
    //                         'dimension',
    //                     ]);
    //                 }
    //             ]);

    //         }
    //     ]);

    //     return $this->find($request->id);
    // }

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

    public function replaceDashWithSpace($name)
    {
        for ($i = 0; $i < count($name); $i++) {
            $name[$i] = str_replace("-", " ", $name[$i]);
        }
        return $name;
    }

    protected function getDiscountCategoryTagIds()
{
    // Replace this with your actual logic to retrieve tag ids for discounts category
    return Tag::where('name_en', 'like', '%discount%')->orWhere('name_ar', 'like', '%خصم%')->pluck('id')->toArray();
}
}
