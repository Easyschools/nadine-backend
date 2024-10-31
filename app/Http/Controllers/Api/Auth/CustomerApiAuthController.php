<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\Api\Auth\CustomerApiAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;

use App\Models\User\User;
use App\Traits\FirebaseFCM;
use App\Traits\HelpersTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerApiAuthController extends Controller
{
    use FirebaseFCM, HelpersTrait;

    private $authService;
    private $verified_code;

    public function __construct(CustomerApiAuthService $authService)
    {
        $this->verified_code = rand(10000, 99999);
        $this->middleware('auth:api')
            ->only('logout', 'changePassword');
        $this->authService = $authService;
    }

    public function register(AuthRequest $request)
    {
        
        $user = $this->authService->register($request, $this->verified_code);

        // send sms message
        //        $this->sendSmsMessage($user->phone, $this->verified_code);

        return $this->sendResponse($user);
    }

    public function logout()
    {
        $process = $this->authService->logout();

        return $this->sendResponse($process);
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
        //   $phone = $this->authService->forgetPassword($request, $this->verified_code);
        $email = $this->authService->forgetPassword($request, $this->verified_code);

        $msg = 'Reset password code: ';

        if ($email == false) {
            return $this->sendError(
                'Something went wrong.'
            );
        }
        dd($email,$this->verified_code,$msg);
        try {
            $res = $this->sendMail($email, $this->verified_code, $msg);
            return $this->sendResponse([
                'code sending via mail'
                // 'phone' => $phone,
                // 'result' => $response
            ]);
        } catch (\Exception $e) {
            return $this->sendError(
                'Something went wrongsss.'
            );
        }

        // try {
        //     $response = $this->sendSmsMessage($phone, $this->verified_code, $msg, 1);

        //     return $this->sendResponse([
        //         'phone' => $phone,
        //         'result' => $response
        //     ]);
        // } catch (\Exception $e) {
        //     return $e->getMessage();
        //     return $this->sendError(
        //         'Something went wrong.'
        //     );
        // }
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
        if (!$user) {
            $this->sendError($user, 'code is wrong!');
        }
        return $this->sendResponse($user);
    }

    public function social(AuthRequest $request)
    {
        $user = $this->authService->social($request);
        return $this->sendResponse($user);
    }


    //    changePassword
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:new_password',
        ]);


        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            // The passwords matches
            return $this->sendError(
                "error",
                "Your current password does not matches with the password you provided. Please try again."
            );
        }

        //Change Password
        $user->password = $request->new_password;
        $user->save();

        return $this->sendResponse("success", "Password changed successfully !");
    }
}
