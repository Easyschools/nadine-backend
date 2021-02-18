<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;;
use App\Models\User\User;
use App\Services\Api\Auth\CustomerApiAuthService;
use App\Traits\FirebaseFCM;
use App\Traits\HelpersTrait;
use Illuminate\Support\Facades\Mail;

class CustomerApiAuthController extends Controller
{
    use FirebaseFCM, HelpersTrait;

    private $authService;
    private $verified_code;

    public function __construct(CustomerApiAuthService $authService)
    {
        $this->verified_code = rand(10000, 99999);

        $this->authService = $authService;
    }

    public function register(AuthRequest $request)
    {
        $user = $this->authService->register($request, $this->verified_code);

        // send sms message
//        $this->sendSmsMessage($user->phone, $this->verified_code);

        return $this->sendResponse($user);
    }

    public function login(AuthRequest $request)
    {
        $user = $this->authService->login($request);
        if ($user == false) {
            return $this->sendError(
                'invalid phone or password'
            );
        }

        // create firebase token
        if ($request->firebase_token) {
            $this->checkFirebaseToken($user->id, $request->firebase_token);
        }


        return $this->sendResponse($user);
    }

    public function forgetPassword(AuthRequest $request)
    {
        $user = $this->authService->forgetPassword($request, $this->verified_code);

        $customer = User::where('phone', $request->phone)->first();

        // send sms message
        $msg = ' كود تذكر الباسورد:  ';
        $this->sendSmsMessage($customer->phone, $this->verified_code, $msg);

        if ($user == false) {
            return $this->sendError(
                'some thing wrong'
            );
        }
        return $this->sendResponse($user);
    }

    public function resetPassword(AuthRequest $request)
    {
        $user = $this->authService->resetPassword($request);
        if ($user == false) {
            return $this->sendError(
                'some thing wrong'
            );
        }
        return $this->sendResponse($user);
    }

    public function checkCode(AuthRequest $request)
    {
        $user = $this->authService->checkCode($request);
        return $this->sendResponse($user);
    }

    public function social(AuthRequest $request)
    {
        $user = $this->authService->social($request);
        return $this->sendResponse($user);
    }


}
