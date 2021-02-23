<?php

namespace App\Models\User;

use App\Models\Region\City;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
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
