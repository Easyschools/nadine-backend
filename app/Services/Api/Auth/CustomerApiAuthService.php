<?php

/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 01:54 م
 */

namespace App\Services\Api\Auth;


use App\Models\User\PasswordReset;
use App\Repositories\AppRepository;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerApiAuthService extends AppRepository
{
    use AuthMethods;
    private $passwordReset;

    public function __construct()
    {
        parent::__construct(new User());
        $this->passwordReset = new AppRepository(new PasswordReset());
    }

    public function register(Request $request, $verified_code)
    {
        $request->merge([
            'type' => 2,
            'verified_code' => $verified_code
        ]);

        if ($request->type_login == 'customer') {
            $user = $this->createCustomerUser($request, $verified_code);
        } elseif ($request->type_login == 'guest') {

            $user = $this->createGuestUser($verified_code);
        }

        unset($user['verified_code']);
        $user['type_login'] = $request->type_login;
        $user['token'] = $user->createToken('Customer Token')->accessToken;

        return $user;
    }

    private function createCustomerUser($request, $verified_code)
    {
        $user = $this->model->create(
            array_merge($request->only(
                'name',
                'phone',
                'password',
                'type',
                'email',
                'image'
            ), [
                'verified_code' => $verified_code,
                'password' => $request->password,
            ])
        );

        return $user;
    }

    private function createGuestUser($verified_code)
    {
        $email = Str::random(10) . '@example.com';
        $phone = '555-' . Str::random(7);
        $randomNumber = rand(1000, 9999);

        // Ensure the generated email is unique
        while (User::where('email', $email)->exists()) {
            $email = Str::random(10) . '@example.com';
        }

        // Ensure the generated phone number is unique
        while (User::where('phone', $phone)->exists()) {
            $phone = '01' . Str::random(9);
        }
        $user = $this->model->create([
            'name' => 'Guest' . $randomNumber,
            'phone' => $phone,
            'password' => 12345678,
            'type' => 2,
            'email' => $email,
            'image' => null,
            'verified_code' => $verified_code,
        ]);
        return $user;
    }


    public function forgetPassword(Request $request, $verified_code = 0)
    {
        $user = $this->findByColumn('email', $request->email);
        if ($user->type != 2) {
            return false;
        }
        $this->passwordReset->model->updateOrCreate([
            'phone' => $user->phone
        ], [
            'token' => $verified_code
        ]);

        dd($user);
        return $user->email;
    }

    public function resetPassword(Request $request)
    {
        //    $this->passwordReset->setConditions([[
        //        'token', $request->code
        //    ]]);
        $user = $this->findByColumn('email', $request->email);
        $reset = $this->passwordReset->findByColumn('phone', $user->phone);
        if ($reset) {
            $this->model->where('phone', $user->phone)
                ->where('type', 2)
                ->first()
                ->update([
                    'password' => $request->password,
                    'verified_code' => null,
                    'phone_verified_at' => Carbon::now(),
                ]);
            return $reset->delete();
        }
        return false;
    }

    public function social(Request $request)
    {
        $user = $this->model->select('id', 'name', 'phone', 'phone_verified_at', 'type')
            ->whereHas('social', function ($social) use ($request) {
                $social->where('provider_id', $request->provider_id);
            })->first();

        if (!$user) {
            $request->merge([
                'type' => 4,
                'phone' => $request->phone,
                'password' => Str::random(10),
            ]);
            $user = $this->model->create($request->only(
                'name',
                'phone',
                'password',
                'type'
            ));
            $user->basicInfo()->create([]);
            $user->social()->create([
                'provider_id' => $request->provider_id,
                'provider' => $request->provider,
            ]);
        }
        $user['token'] = $user->createToken(' token')->accessToken;
        return $user;
    }

    public function checkCode(Request $request)
    {
        $exists = $this->passwordReset->model->where(
            'phone',
            $request->phone
        )
            ->where('token', $request->code)
            ->exists();
        return $exists;
    }
}
