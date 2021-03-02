<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CustomerRequest;
use App\Services\Api\Auth\CustomerApiService;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    private $customerService;

    public function __construct(CustomerApiService $customerService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1,2')
            ->only([ 'index' , 'update','get']);
        $this->middleware('check.role:1')
            ->only('delete');
        $this->customerService = $customerService;
    }

    public function update(CustomerRequest $request)
    {
        $process = $this->customerService->updateCustomer($request);
        return $this->sendResponse($process);
    }

    public function get(CustomerRequest $request)
    {
        $process = $this->customerService->get($request->id);
        return $this->sendResponse($process);
    }

    public function index(CustomerRequest $request)
    {
        $process = $this->customerService->index($request);
        return $this->sendResponse($process);
    }

    public function delete(CustomerRequest $request)
    {
        $process = $this->customerService->deleteCustomer($request->id);
        if (!$process) {
            return $this->sendError('sorry, something wrong');
        }
        return $this->sendResponse($process);
    }
}
