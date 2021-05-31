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
use Illuminate\Http\Request;

class ProductApiController extends Controller
{

    private $productApiService;

    public function __construct(ProductApiService $productApiService)
    {
//        $this->middleware('auth:api');
        $this->middleware(['auth:api','check.role:1,2 '])
            ->only(['create','update']);
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

    public function replaceImage()
    {
        $process = $this->productApiService->replaceProduct();
        return $this->sendResponse($process);

    }
}
