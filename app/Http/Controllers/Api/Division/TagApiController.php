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
