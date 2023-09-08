<?php

namespace App\Models\User;

use App\Models\Order\Order;
use App\Models\Region\District;
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
        'district_id',
        'address',
    ];


    public function getForeignKey()
    {
        return 'address_id';
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
