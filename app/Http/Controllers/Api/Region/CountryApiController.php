<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Region;


use App\Http\Controllers\Controller;
use App\Http\Requests\Region\CountryRequest;
use App\Services\Dashboard\Region\CountryApiService;

class CountryApiController extends Controller
{

    private $countryService;

    public function __construct(CountryApiService $countryService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->countryService = $countryService;
    }


    public function read(CountryRequest $request)
    {
        $process = $this->countryService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CountryRequest $request)
    {
        $process = $this->countryService->index($request);
        return $this->sendResponse($process);
    }
}
