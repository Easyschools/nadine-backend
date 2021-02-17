<?php

namespace App\Policies\Country;


use App\Models\Country\Country;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class StorePolicy.
 */
class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the store.
     *
     * @param User $user
     * @param Country $country
     * @return bool
     */
    public function view(User $user, Country $country)
    {
        return $user->isAdmin() || $user->isCustomer();
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() ;
    }

    /**
     * Determine whether the user can update the country.
     *
     * @param  $user
     * @param Country $country
     * @return mixed
     */
    public function update(User $user, Country $country)
    {
        return $user->isAdmin() || $user->isCustomer();
    }

    /**
     * Determine whether the user can delete the country.
     *
     * @param  $user
     * @param Country $country
     * @return mixed
     */
    public function delete(User $user, Country $country)
    {
        return $user->isAdmin() || $user->isCustomer();
    }
}
