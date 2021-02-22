<?php

namespace App\Models\User;

use App\Models\Region\City;
use App\Models\User\Relations\UserRelations;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Address extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'city_id',
        'address',
    ];


    public function getForeignKey()
    {
        return 'address_id';
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
