<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Other;


use App\Http\Controllers\Controller;
use App\Http\Requests\Other\ContactRequest;
use App\Services\Api\Other\ContactApiService;

class ContactApiController extends Controller
{

    private $contactApiService;

    public function __construct(ContactApiService $contactApiService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->contactApiService = $contactApiService;
    }


    public function read(ContactRequest $request)
    {
        $process = $this->contactApiService->get($request);
        return $this->sendResponse($process);
    }

    public function create(ContactRequest $request)
    {
        $process = $this->contactApiService->createContact($request);
        return $this->sendResponse($process);
    }


    public function delete(ContactRequest $request)
    {
        $process = $this->contactApiService->delete($request->id);
        return $this->sendResponse($process);
    }


    public function all(ContactRequest $request)
    {
        $process = $this->contactApiService->index($request);
        return $this->sendResponse($process);
    }

    public function getCountOfunRead(ContactRequest $request)
    {
        $process = $this->contactApiService->getCountOfUnreadMessages();
        return $this->sendResponse($process);
    }
}
