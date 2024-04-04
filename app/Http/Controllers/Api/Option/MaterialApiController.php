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
use App\Http\Requests\Option\MaterialRequest;
use App\Services\Api\Option\MaterialApiService;

class MaterialApiController extends Controller
{

    private $materialApiService;

    public function __construct(MaterialApiService $materialApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->materialApiService = $materialApiService;
    }


    public function read(MaterialRequest $request)
    {
        $process = $this->materialApiService->get($request);
        return $this->sendResponse($process);
    }

        public function getMaterialVariants(MaterialRequest $request)
    {
        $process = $this->materialApiService->getMaterialVariants($request);
        return $this->sendResponse($process);
    }


    public function all(MaterialRequest $request)
    {
        $process = $this->materialApiService->index($request);
        return $this->sendResponse($process);
    }

    public function create(MaterialRequest $request)
    {
        $process = $this->materialApiService->createMaterial($request);
        return $this->sendResponse($process);
    }
    public function edit(MaterialRequest $request)
    {
        $process = $this->materialApiService->editMaterial($request);
        return $this->sendResponse($process);
    }
    public function delete(MaterialRequest $request)
    {
        $process = $this->materialApiService->delete($request->id);
        return $this->sendResponse($process);
    }
}
