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
        $user = $this->model->create(
            array_merge($request->only(
                'name', 'phone', 'password', 'type',
                'image'
            ), [
                'verified_code' => $verified_code,
                'password' => $request->password    ,
            ]));

        unset($user['verified_code']);
        $user['token'] = $user->createToken('Customer Token')->accessToken;
        return $user;
    }

    public function forgetPassword(Request $request , $verified_code = 0)
    {
        $user = $this->findByColumn(
            'phone', $request->phone
        );

        if ($user->type != 2) {
            return false;
        }
        $this->passwordReset->model->updateOrCreate([
            'phone' => $request->phone
        ], [
            'token' => $verified_code
        ]);
        return true;
    }

    public function resetPassword(Request $request)
    {
        $this->passwordReset->setConditions([[
            'token', $request->code
        ]]);
        $reset = $this->passwordReset->findByColumn(
            'phone', $request->phone
        );
        if ($reset) {
            $this->model->where('phone', $request->phone)
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
                'name', 'phone', 'password', 'type'
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
            'phone', $request->phone
        )
            ->where('token', $request->code)
            ->exists();
        return $exists;
    }

}
