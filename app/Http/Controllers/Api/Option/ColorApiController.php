<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Option;


use App\Http\Controllers\Controller;
use App\Http\Requests\Option\ColorRequest;
use App\Services\Api\Option\ColorApiService;

class ColorApiController extends Controller
{

    private $colorApiService;

    public function __construct(ColorApiService $colorApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->colorApiService = $colorApiService;
    }


    public function read(ColorRequest $request)
    {
        $process = $this->colorApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(ColorRequest $request)
    {
        $process = $this->colorApiService->index($request);
        return $this->sendResponse($process);
    }


    public function delete(ColorRequest $request)
    {
        $process = $this->colorApiService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(ColorRequest $request)
    {
        $process = $this->colorApiService->createColor($request);
        return $this->sendResponse($process);
    }
    public function edit(ColorRequest $request)
    {
        $process = $this->colorApiService->editColor($request);
        return $this->sendResponse($process);
    }
}
