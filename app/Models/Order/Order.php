<?php

namespace App\Models\Order;

use App\Models\User\Address;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'coupon_id',
        'subtotal',
        'discount',
        'total',
        'notes',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

}
