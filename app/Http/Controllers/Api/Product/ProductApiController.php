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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Date;

class ProductApiController extends Controller
{

    private $productApiService;

    public function __construct(ProductApiService $productApiService)
    {
        $this->middleware(['auth:api', 'check.role:1,2'])
            ->only(['create', 'update', 'import', 'export']);
        $this->productApiService = $productApiService;
    }

    public function read(ProductRequest $request)
    {
        $process = $this->productApiService->get($request);
        return $this->sendResponse($process);
    }
    public function getVariants(ProductRequest $request)
    {
        $process = $this->productApiService->getVariants($request);
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

    public function highEnd(ProductRequest $request)
    {
        $process = $this->productApiService->highEnd($request);
        if ($request->sendResponse) {
            return $this->sendResponse($process);
        }

        return $this->sendResponse($process);
    }

    public function makeLook(ProductRequest $request)
    {
         $process = $this->productApiService->makeLook($request);
        // if ($request->sendResponse) {
        //     return $this->sendResponse($process->toArray());
        // }

        return $this->sendResponse($process->toArray());
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

    public function getLimitedEdtion(ProductRequest $request)
    {
        $process = $this->productApiService->getLimitedEdtion($request);
        return $this->sendResponse($process);
    }
    

    public function getLatest(ProductRequest $request)
    {
        $process = $this->productApiService->getLatest($request);
        return $this->sendResponse($process);
    }

    public function getNewArrival(ProductRequest $request)
    {
        $process = $this->productApiService->getNewArrival($request);
        return $this->sendResponse($process);
    }

    public function import(ProductRequest $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));
        return [
            'message' => 'Products modifications imported successfully',
        ];
    }

    public function export()
    {
        $path = 'products-' . Date::now()->format('Y-m-d-H-i-s') . '.xlsx';
        Excel::store(new ProductsExport, $path, 'public');
        return $this->sendResponse(url('storage/' . $path), 'Products list url.');
    }

    public function getSubProduct(ProductRequest $request)
    {
        $process = $this->productApiService->getSubProduct($request);
        return $this->sendResponse($process);
    }
}
