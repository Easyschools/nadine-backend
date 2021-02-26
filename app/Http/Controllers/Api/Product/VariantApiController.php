<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 21/02/21
 * Time: 11:50 ص
 */

namespace App\Http\Controllers\Api\Product;


use App\Http\Controllers\Controller;
use App\Http\Requests\Product\VariantRequest;
use App\Services\Api\Product\VariantApiService;

class VariantApiController extends Controller
{

    private $variantApiService;

    public function __construct(VariantApiService $variantApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->variantApiService = $variantApiService;
    }


    public function read(VariantRequest $request)
    {
        $process = $this->variantApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(VariantRequest $request)
    {
        $process = $this->variantApiService->index($request);
        return $this->sendResponse($process);
    }
}
