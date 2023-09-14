<?php

/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Feature;


use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\CollectionRequest;
use App\Models\Feature\Collection;
use App\Services\Api\Feature\CollectionApiService;

class CollectionApiController extends Controller
{
    private $collectionApiService;

    public function __construct(CollectionApiService $collectionApiService)
    {
        //        $this->middleware('auth:api');
        //        $this->middleware('check.role:1,2 ')
        //            ->only(['index','read']);
        $this->collectionApiService = $collectionApiService;
    }


    public function read(CollectionRequest $request)
    {
        $process = $this->collectionApiService->get($request);
        return $this->sendResponse($process);
    }


    public function getBySlug(CollectionRequest $request)
    {
        $collection = Collection::where('slug', $request->slug)->first();

        if (!$collection) {
            throw new \App\Exceptions\NotFoundException(__('Not found.'));
        }

        $products = $collection->simpleProducts()
            ->select('id', 'name_en', 'name_ar', 'slug', 'sku', 'price', 'price_after_discount', 'tag_id')
            ->with([
                'variants:id,color_id,dimension_id,additional_price,product_id',
                'variants.color:id,name_en,name_ar',
                'variants.dimension:id,dimension',
            ])
            ->paginate(16);

        return $this->sendResponse(array_merge(
            $collection->toArray(),
            ['products' => $products],
        ));
    }

    public function all(CollectionRequest $request)
    {
        $process = $this->collectionApiService->index($request);
        return $this->sendResponse($process);
    }


    public function create(CollectionRequest $request)
    {
        $process = $this->collectionApiService->createCollection($request);
        return $this->sendResponse($process);
    }
    public function edit(CollectionRequest $request)
    {
        $process = $this->collectionApiService->editCollection($request);
        return $this->sendResponse($process);
    }
    public function delete(CollectionRequest $request)
    {
        $process = $this->collectionApiService->delete($request->id);
        return $this->sendResponse($process);
    }
}
