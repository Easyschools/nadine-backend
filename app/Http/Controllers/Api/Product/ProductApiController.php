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
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
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
        return $this->sendResponse($process);
    }

    public function create(Request $request)
    {
//        dd($request->all());
        $process = $this->productApiService->createProduct($request);
        return $this->sendResponse($process);
    }

    public function edit(Request $request)
    {
//        dd($request->all());
        $process = $this->productApiService->updateProduct($request);
        return $this->sendResponse($process);
    }
}
