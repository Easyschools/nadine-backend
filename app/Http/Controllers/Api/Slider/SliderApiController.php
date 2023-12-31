<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Slider;


use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SliderRequest;
use App\Services\Api\Slider\SliderApiService;

class SliderApiController extends Controller
{

    private $sliderApiService;

    public function __construct(SliderApiService $sliderApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->sliderApiService = $sliderApiService;
    }


    public function read(SliderRequest $request)
    {
        $process = $this->sliderApiService->get($request);
        return $this->sendResponse($process);
    }


    public function all(SliderRequest $request)
    {
        $process = $this->sliderApiService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(SliderRequest $request)
    {
        $process = $this->sliderApiService->delete($request->id);
        return $this->sendResponse($process);
    }
    public function create(SliderRequest $request)
    {
        $process = $this->sliderApiService->createSlider($request);
        return $this->sendResponse($process);
    }
    public function edit(SliderRequest $request)
    {
        $process = $this->sliderApiService->editSlider($request);
        return $this->sendResponse($process);
    }
}
