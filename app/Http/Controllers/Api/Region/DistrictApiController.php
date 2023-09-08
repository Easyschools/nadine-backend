<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Region;


use App\Http\Controllers\Controller;
use App\Http\Requests\Region\DistrictRequest;
use App\Services\Api\Region\DistrictApiService;

class DistrictApiController extends Controller
{

    private $districtService;

    public function __construct(DistrictApiService $districtService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->districtService = $districtService;
    }


    public function read(DistrictRequest $request)
    {
        $process = $this->districtService->get($request);
        return $this->sendResponse($process);
    }


    public function all(DistrictRequest $request)
    {
        $process = $this->districtService->index($request);
        return $this->sendResponse($process);
    }
}
