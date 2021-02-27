<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Feature;


use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\CollectionRequest;
use App\Services\Api\Feature\CollectionApiService;

class CollectionApiController extends Controller
{

    private $collectionApiService;

    public function __construct(CollectionApiService $collectionApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->collectionApiService = $collectionApiService;
    }


    public function read(CollectionRequest $request)
    {
        $process = $this->collectionApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CollectionRequest $request)
    {
        $process = $this->collectionApiService->index($request);
        return $this->sendResponse($process);
    }


    public function create(CollectionRequest $request)
    {
        $process = $this->collectionApiService->createCollection($request);
        return $this->sendResponse($process);
    }
    public function edit(CollectionRequest $request)
    {
        $process = $this->collectionApiService->editCollection($request);
        return $this->sendResponse($process);
    }
    public function delete(CollectionRequest $request)
    {
        $process = $this->collectionApiService->delete($request->id);
        return $this->sendResponse($process);
    }

}
