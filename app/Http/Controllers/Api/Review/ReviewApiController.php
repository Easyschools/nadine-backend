<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewRequest;
use App\Services\Api\Review\ReviewApiService;


class ReviewApiController extends Controller
{
    protected $reviewApiService;

    public function __construct(ReviewApiService $reviewApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:3,4')
//            ->only(['create', 'update']);
//        $this->middleware('check.role:1,4')
//            ->only(['delete']);
        $this->reviewApiService = $reviewApiService;
    }

    public function create(ReviewRequest $request)
    {

        $process = $this->reviewApiService->createReview($request);
        return $this->sendResponse($process);
    }

    public function update(ReviewRequest $request)
    {

        $process = $this->reviewApiService->updateReview($request);
        return $this->sendResponse($process);
    }


    public function delete(ReviewRequest $request)
    {
        $process = $this->reviewApiService->delete($request->id);
        return $this->sendResponse($process);
    }

    public function all(ReviewRequest $request)
    {
        $process = $this->reviewApiService->index($request);
        return $this->sendResponse($process);
    }

    public function read(ReviewRequest $request)
    {
        $process = $this->reviewApiService->get($request);
        return $this->sendResponse($process);
    }
}
