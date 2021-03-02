<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Other;


use App\Http\Controllers\Controller;
use App\Http\Requests\Other\ContactInfoRequest;
use App\Services\Api\Other\ContactInfoApiService;

class ContactInfoApiController extends Controller
{

    private $contactInfoService;

    public function __construct(ContactInfoApiService $contactInfoService)
    {
        $this->middleware(['auth:api','check.role:1,2 '])
            ->only(['update','delete','create']);
        $this->contactInfoService = $contactInfoService;
    }


    public function create(ContactInfoRequest $request)
    {

        $process = $this->contactInfoService->createContactInfo($request);
        return $this->sendResponse($process);
    }

    public function update(ContactInfoRequest $request)
    {

        $process = $this->contactInfoService->updateContactInfo($request);
        return $this->sendResponse($process);
    }

    public function read(ContactInfoRequest $request)
    {
        $process = $this->contactInfoService->get($request);
        return $this->sendResponse($process);
    }


    public function all(ContactInfoRequest $request)
    {
        $process = $this->contactInfoService->index($request);
        return $this->sendResponse($process);
    }
}
