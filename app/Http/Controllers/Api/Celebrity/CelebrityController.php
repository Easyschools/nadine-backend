<?php

namespace App\Http\Controllers\Api\Celebrity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Celebrity\CelebrityRequest;
use App\Services\Api\Celebrity\CelebrityApiService;
use Illuminate\Http\Request;

class CelebrityController extends Controller
{
    private $celebrityApiService;

    public function __construct(CelebrityApiService $celebrityApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->celebrityApiService = $celebrityApiService;
    }


    public function read(CelebrityRequest $request)
    {
        $process = $this->celebrityApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CelebrityRequest $request)
    {
        $process = $this->celebrityApiService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(CelebrityRequest $request)
    {
        $process = $this->celebrityApiService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(CelebrityRequest $request)
    {
        $process = $this->celebrityApiService->createCelebrity($request);
        return $this->sendResponse($process);
    }
    public function edit(CelebrityRequest $request)
    {
        $process = $this->celebrityApiService->editSlider($request);
        return $this->sendResponse($process);
    }
}
