<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 11/11/20
 * Time: 12:53 م
 */

namespace App\Services\Api\Auth;


use App\Models\User\User;
use App\Repositories\AppRepository;
use App\Traits\FirebaseFCM;
use Illuminate\Http\Request;

class AuthApiService extends AppRepository
{
    use AuthMethods , FirebaseFCM;

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function ban(Request $request)
    {
        $user = $this->update($request->user_id, [
            'is_ban' => $request->is_ban
        ]);
        if ($user->is_ban == 1) {
            return $user->OauthAccessToken()->delete();
        }
        return true;
    }
}
