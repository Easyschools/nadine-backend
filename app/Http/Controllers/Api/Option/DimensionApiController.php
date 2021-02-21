<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Option;


use App\Http\Controllers\Controller;
use App\Http\Requests\Option\DimensionRequest;
use App\Services\Dashboard\Option\DimensionApiService;

class DimensionApiController extends Controller
{

    private $dimensionApiService;

    public function __construct(DimensionApiService $dimensionApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->dimensionApiService = $dimensionApiService;
    }


    public function read(DimensionRequest $request)
    {
        $process = $this->dimensionApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(DimensionRequest $request)
    {
        $process = $this->dimensionApiService->index($request);
        return $this->sendResponse($process);
    }
}
