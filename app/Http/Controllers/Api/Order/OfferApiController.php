<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OfferRequest;
use App\Services\Api\Order\OfferApiService;

class OfferApiController extends Controller
{

    private $offerApiService;

    public function __construct(OfferApiService $offerApiService)
    {
        //        $this->middleware('auth:api');
        //        $this->middleware('check.role:1,2 ')
        //            ->only(['index','read']);
        $this->offerApiService = $offerApiService;
    }

    public function read(OfferRequest $request)
    {
        $process = $this->offerApiService->get($request);
        return $this->sendResponse($process);
    }

    public function all(OfferRequest $request)
    {
        $process = $this->offerApiService->index($request);
        return $this->sendResponse($process);
    }

    public function create(OfferRequest $request)
    {
        // return $request->all();
        if ($request->has('tags')) {
            $tags = explode(',', $request->tags);
            $request->merge(['tags' => $tags]);
        }
        // return $request;
        $process = $this->offerApiService->createOffer($request);
        return $this->sendResponse($process);
    }

    public function edit(OfferRequest $request)
    {
        if (!empty($request->tags) && $request->has('tags')) {
            $tags = explode(',', $request->tags);
            $request->merge(['tags' => $tags]);
        }

        $process = $this->offerApiService->editOffer($request);
        return $this->sendResponse($process);
    }
    public function delete(OfferRequest $request)
    {
        $process = $this->offerApiService->delete($request->id);
        return $this->sendResponse($process);
    }
}
