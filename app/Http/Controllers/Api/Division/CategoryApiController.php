<?php

/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Division;


use App\Http\Controllers\Controller;
use App\Http\Requests\Division\CategoryRequest;
use App\Models\Division\Category;
use App\Services\Api\Division\CategoryApiService;

class CategoryApiController extends Controller
{

    private $categoryService;

    public function __construct(CategoryApiService $categoryService)
    {
        //        $this->middleware('auth:api');
        //        $this->middleware('check.role:1,2 ')
        //            ->only(['index','read']);
        $this->categoryService = $categoryService;
    }


    public function read(CategoryRequest $request)
    {
        $process = $this->categoryService->get($request);
        return $this->sendResponse($process);
    }

    public function getProducts(CategoryRequest $request)
    {
        $process = $this->categoryService->getProducts($request);
        return $this->sendResponse($process);
    }

    public function getBySlug(CategoryRequest $request)
    {
        $process = $this->categoryService->getBySlug($request);
        return $this->sendResponse($process);
    }

    public function getCategoriesWithSamples(CategoryRequest $request)
    {
        return Category::with(['simpleProducts' => function ($query) {
            $query->select('products.id', 'products.name_en', 'products.name_ar', 'products.slug', 'products.sku', 'products.price', 'products.price_after_discount', 'products.tag_id')
                ->take(6);
        }])->paginate(16);
    }

    public function all(CategoryRequest $request)
    {
        $process = $this->categoryService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(CategoryRequest $request)
    {
        $process = $this->categoryService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(CategoryRequest $request)
    {
        $process = $this->categoryService->createCategory($request);
        return $this->sendResponse($process);
    }
    public function edit(CategoryRequest $request)
    {
        $process = $this->categoryService->editCategory($request);
        return $this->sendResponse($process);
    }
}
