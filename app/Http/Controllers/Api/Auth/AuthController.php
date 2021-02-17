<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\AuthRequest;
use App\Models\User\User;
use App\Services\Auth\AuthMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    protected $authMethods;

    public function __construct(AuthMethods $authMethods)
    {
        $this->authMethods = $authMethods;
        $this->middleware('auth:api')
            ->only('logout','changePassword');
    }

    public function register(AuthRequest $request)
    {
        $user = $this->authMethods->register($request);
        return $this->sendResponse($user, 'user registration');
    }


    public function login(AuthRequest $request)
    {
        dd('zzz');
        $data = $this->authMethods->login($request);
        if ($data === false) {
            return $this->sendError('invalid email or password');
        }
        return $this->sendResponse($data);
    }

    public function logout()
    {
        $data = $this->authMethods->logout();
        if ($data === false) {
            return $this->sendError('something wrong');
        }
        return $this->sendResponse('Good Bye');
    }

    public function changePassword(AuthRequest $request)
    {
        $data = $this->authMethods->changePassword($request);
        if ($data) {
            return $this->sendResponse('done');
        }
        return $this->sendError('try again');
    }

    public function forgetPassword(AuthRequest $request)
    {
        $data = $this->authMethods->forgetPassword($request);
         if ($data === false) {
            return $this->sendError('invalid email or password');
        }
        return $this->sendResponse('please, check your email');
    }

    public function resetPassword(AuthRequest $request)
    {

        $data =$this->authMethods->resetPassword($request);
        if ($data) {
            return $this->sendResponse('done');
        }
        return $this->sendError('try again');
    }

}
