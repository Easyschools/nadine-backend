<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User\User;
use App\Services\Api\Auth\AuthApiService;
use App\Traits\FirebaseFCM;
use App\Traits\HelpersTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use  FirebaseFCM, HelpersTrait;

    private $authService;

    public function __construct(AuthApiService $authService)
    {
//        $this->middleware('auth:api')
//            ->except('login');
//
//        $this->middleware('check.role:1')
//            ->only('ban');

        $this->authService = $authService;
    }

    public function login(AuthRequest $request)
    {
        $request->merge([
            'phone' => $request->username
        ]);
        $user = $this->authService->login($request, $request->type);
        if ($user == false) {
            return $this->sendError(
                'invalid phone or password'
            );
        }
        // create firebase token
        if ($request->firebase_token) {
            $this->checkFirebaseToken($user->id, $request->firebase_token);
        }

//        $this->sendSmsMessage($user->phone, $request->verified_code);

        return $this->sendResponse($user);
    }

    public function logout(AuthRequest $request)
    {
        $user = $this->authService->logout($request);
        return $this->sendResponse($user);
    }

    public function changePassword(AuthRequest $request)
    {
        $user = $this->authService->changePassword(
            $request->old_password, $request->password, $request->user_id
        );
        return $this->sendResponse($user);
    }

    public function ban(AuthRequest $request)
    {
        $process = $this->authService->ban($request);
        return $this->sendResponse($process);
    }

}
