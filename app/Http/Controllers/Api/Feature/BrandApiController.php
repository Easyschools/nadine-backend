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
use App\Services\Dashboard\Feature\BrandApiService;

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
}
