<?php

namespace App\Models\Order;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'is_percentage',
        'value',
        'max_usage_per_order',
        'max_usage_per_user',
        'min_total',
        'all_users',
        'users',
    ];


    public function getUsersAttribute($value)
    {
        return json_decode($value);
    }

    public function setUsersAttribute($value)
    {
        $this->attributes['users'] = json_encode($value);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('used');
    }

    public function getUsers()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('used');
    }


}
