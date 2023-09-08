<?php

namespace App\Observers;


use App\Models\User\User;
use App\Traits\HelperFunctions;

class UserObserver
{

    public function deleted(User $user)
    {
        HelperFunctions::removeImage($user->image);
    }

    public function updating(User $user)
    {
        if ($user->isDirty('image')) {
            HelperFunctions::removeImage($user->getOriginal('image'));
        }
    }

}
