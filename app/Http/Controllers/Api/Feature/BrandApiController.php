<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Feature;


use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\BrandRequest;
use App\Services\Api\Feature\BrandApiService;

class BrandApiController extends Controller
{

    private $brandService;

    public function __construct(BrandApiService $brandService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->brandService = $brandService;
    }


    public function read(BrandRequest $request)
    {
        $process = $this->brandService->get($request);
        return $this->sendResponse($process);
    }


    public function all(BrandRequest $request)
    {
        $process = $this->brandService->index($request);
        return $this->sendResponse($process);
    }



    public function delete(BrandRequest $request)
    {
        $process = $this->brandService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(BrandRequest $request)
    {
        $process = $this->brandService->createBrand($request);
        return $this->sendResponse($process);
    }
    public function edit(BrandRequest $request)
    {
        $process = $this->brandService->editBrand($request);
        return $this->sendResponse($process);
    }
}
