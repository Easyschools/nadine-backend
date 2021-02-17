<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 28/09/20
 * Time: 01:52 م
 */

namespace App\Services\Auth;


use App\Mail\ForgetPasswordMail;
use App\Models\User\User;
use App\Repositories\AppRepository;
use Illuminate\Http\Request;
use App\Models\User\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use DB;
class AuthMethods
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new AppRepository(new User());
    }

    public function register(Request $request)
    {
        $userService=new UserService();
        $user = $userService->create($request);
        $user['token'] = $user->createToken('user token')->accessToken;
        return $user;
    }

    public function login(Request $request)
    {
        $this->userRepo->setConditions([['is_admin', 0]]);
        $user = $this->userRepo->findByColumn('email', $request->email);
        if (!$user) {
            return false;
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return false;
        }
//        DB::table('users')->where('id', $user->id)
//            ->update([
//                'hash_token' =>
//                    bin2hex(openssl_random_pseudo_bytes(50) . 'login-user-' . $user->id)
//            ]);
        $user['token'] = $user->createToken('user token')->accessToken;
        return $user;
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->OauthAccessToken()->delete();
            return true;
        }
        return false;
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin == 1) {
            $user = $this->userRepo->find($request->user_id);
        }
        $check = Hash::check($request->old_password, $user->password);
        if (!$check) {
            throw ValidationException::withMessages([
                'old_password' => ['invalid old password'],
            ]);
        }
        return $this->userRepo->update($user->id, ['password' => $request->password]);
    }

    public function forgetPassword(Request $request)
    {
        $token = str_random(20);
        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token
                // 'id'=>null
            ],
            // ['id'=>null]
        );
        // dd(123);
        $user = User::where('email', $request->email)
            ->first();
        if($user){
        Mail::to($request->email)->send(new ForgetPasswordMail($token, $user));
        }elseif(!$user)
        {
            return false;
        }
        return true;
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $passwordReset = PasswordReset::where(
            'token', $request->token
        )->first();
        
        if ($passwordReset) {
            $email = $passwordReset->email;
            $user=User::where('email', $email)
            
            ->first()
              ->update([
                  'password' => ($request->new_password)
                  ]);
                
                    return $user;
        }
        // $passwordReset->delete();

     

    }
}
