<?php

namespace App\Models\Order;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isEmpty;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'is_percentage',
        'value',
        'max_usage',
        'used_times',
        'min_total',
        'all_users',
        'users',
    ];

    protected $appends = [
        'users_of_coupon'
    ];

    protected $with = ['user'];

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
        return $this->belongsToMany(User::class, 'coupon_user');
    }

    public function getUsers()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('used');
    }

    public function getUsersOfCouponAttribute()
    {
        if (collect($this->users)->count() > 0) {
            return User::whereIn('id', $this->users)->pluck('name','phone')->toArray();
        }
        return [];
    }


}
