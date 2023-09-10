<?php

/**
 * Created by PhpStorm.
 * User: amir
 * Date: 21/02/21
 * Time: 11:50 ص
 */

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Services\Api\Product\ProductApiService;

class ProductApiController extends Controller
{

    private $productApiService;

    public function __construct(ProductApiService $productApiService)
    {
        //        $this->middleware('auth:api');
        $this->middleware(['auth:api', 'check.role:1,2 '])
            ->only(['create', 'update']);
        $this->productApiService = $productApiService;
    }

    public function read(ProductRequest $request)
    {
        $process = $this->productApiService->get($request);
        return $this->sendResponse($process);
    }

    public function all(ProductRequest $request)
    {
        $process = $this->productApiService->index($request);
        if ($request->sendResponse) {
            return $this->sendResponse($process);
        }
        return $this->sendResponse($process);
    }

    public function allWeb(ProductRequest $request)
    {
        $process = $this->productApiService->indexWeb($request);
        if ($request->sendResponse) {
            return $this->sendResponse($process);
        }
        return $this->sendResponse($process);
    }

    public function create(ProductRequest $request)
    {
        $process = $this->productApiService->createProduct($request);
        return $this->sendResponse($process);
    }

    public function edit(ProductRequest $request)
    {
        $process = $this->productApiService->updateProduct($request);
        return $this->sendResponse($process);
    }

    public function delete(ProductRequest $request)
    {
        $process = $this->productApiService->delete($request->id);
        return $this->sendResponse($process);
    }

    public function priceRange()
    {
        $process = $this->productApiService->priceRange();
        return $this->sendResponse($process);
    }

    public function search(ProductRequest $request)
    {
        $process = $this->productApiService->Product_category_search($request);
        return $this->sendResponse($process);
    }

    public function offers(ProductRequest $request)
    {
        $process = $this->productApiService->offers($request);
        return $this->sendResponse($process);
    }

    public function getBestSellers(ProductRequest $request)
    {
        $process = $this->productApiService->getBestSellers($request);
        return $this->sendResponse($process);
    }
}
