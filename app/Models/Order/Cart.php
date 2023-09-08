<?php

namespace App\Models\Order;

use App\Models\User\User;
use App\Models\Product\Variant;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'user_id',
        'variant_id',
        'quantity',
        'checkout',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
