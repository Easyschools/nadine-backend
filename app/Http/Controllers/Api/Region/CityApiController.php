<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Region;


use App\Http\Controllers\Controller;
use App\Http\Requests\Region\CityRequest;
use App\Services\Dashboard\Region\CityApiService;

class CityApiController extends Controller
{

    private $cityService;

    public function __construct(CityApiService $cityService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1,2 ')
            ->only(['index','read']);
        $this->cityService = $cityService;
    }


    public function read(CityRequest $request)
    {
        $process = $this->cityService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CityRequest $request)
    {
        $process = $this->cityService->index($request);
        return $this->sendResponse($process);
    }
}
