<?php

/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Division;

use Illuminate\Http\Request;
use App\Models\Division\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Division\TagRequest;
use App\Services\Api\Division\TagApiService;

class TagApiController extends Controller
{

    private $tagService;

    public function __construct(TagApiService $tagService)
    {
        //        $this->middleware('auth:api');
        //        $this->middleware('check.role:1,2 ')
        //            ->only(['index','read']);
        $this->tagService = $tagService;
    }


    public function read(TagRequest $request)
    {
        $process = $this->tagService->get($request);
        return $this->sendResponse($process);
    }

    public function getBySlug(TagRequest $request)
    {
        $tag = Tag::where('slug', $request->slug)
            ->with(
                'category',
                'customTagShippingPrice:id,tag_id,cost_inside_cairo,cost_outside_cairo'
            )->first();

        if (!$tag) {
            throw new \App\Exceptions\NotFoundException(__('Not found.'));
        }

        $products = $tag->simpleProducts()
            ->select('id', 'name_en', 'name_ar', 'slug', 'sku', 'price', 'price_after_discount', 'tag_id')
            ->with([
                'variants:id,color_id,dimension_id,additional_price,product_id',
                'variants.color:id,name_en,name_ar',
                'variants.dimension:id,dimension',
            ])
            ->paginate(16);

        return $this->sendResponse(array_merge(
            $tag->toArray(),
            ['products' => $products],
        ));
    }

    public function all(Request $request)
    {
        $validator = Validator($request->all(), [
            'is_paginate' => 'in:0,1',

        ]);
        if ($validator->fails()) {
            return $this->sendError('error validation', $validator->errors());
        }
        $Tag = Tag::with(
            'category',
            'customTagShippingPrice',

        )->withCount('products');

        if (!$request->is_paginate) {
            $Tag = $Tag->get();
        } else {
            $Tag = $Tag->paginate(15);
        }
        return $this->sendResponse($Tag, "Tag Seen Successfully");
    }

    public function getTop(Request $request)
    {
        $Tag = Tag::with(
            'category',
            'customTagShippingPrice',
        )->withCount('products')->orderBy('products_count', 'desc')->limit(10)->get();

        return $this->sendResponse($Tag, "Top Tags Listed Successfully");
    }


    public function delete(TagRequest $request)
    {
        $process = $this->tagService->delete($request->id);
        return $this->sendResponse($process);
    }

    public function create(TagRequest $request)
    {
        $process = $this->tagService->createTag($request);
        return $this->sendResponse($process);
    }
    public function edit(TagRequest $request)
    {
        $process = $this->tagService->editTag($request);
        return $this->sendResponse($process);
    }
}
