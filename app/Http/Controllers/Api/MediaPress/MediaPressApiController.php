<?php

namespace App\Http\Controllers\Api\MediaPress;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaPress\MediaPressRequest;
use App\Services\Api\MediaPress\MediaPressApiService;
use Illuminate\Http\Request;

class MediaPressApiController extends Controller
{
    private $mediaPressApiService;

    public function __construct(MediaPressApiService $mediaPressApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->mediaPressApiService = $mediaPressApiService;
    }


    public function read(MediaPressRequest $request)
    {
        $process = $this->mediaPressApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(MediaPressRequest $request)
    {
        $process = $this->mediaPressApiService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(MediaPressRequest $request)
    {
        $process = $this->mediaPressApiService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(MediaPressRequest $request)
    {
        $process = $this->mediaPressApiService->createMediaPress($request);
        return $this->sendResponse($process);
    }
    public function edit(MediaPressRequest $request)
    {
        $process = $this->mediaPressApiService->editSlider($request);
        return $this->sendResponse($process);
    }
}
