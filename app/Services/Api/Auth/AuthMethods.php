<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 02:53 م
 */

namespace App\Services\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

trait AuthMethods
{
    public function login(Request $request, $type = 4 )
    {
        $this->setColumns(['id', 'name',
            'phone_verified_at', 'password', 'type',  'phone'
        ]);
        $this->setConditions([['type', 2]]);
        $user = $this->findByColumn('phone', $request->phone);
        if (!$user) {
            return false;
        }
        if ($user->is_ban == 1) {
            abort(403, 'your account has been banned');
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return false;
        };


        $user['token'] = $user->createToken($user->user_type . ' Token')->accessToken;
        return $user;
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $user->authAccessToken()->delete();

//            if ($user->firebaseToken()->count() > 0) {
//                $user->firebaseToken()->delete();
//            }


            return true;
        }
        return false;
    }

}
