<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'is_percentage',
        'discount',
        'max_usage_per_order',
        'max_usage_per_user',
        'min_total',
        'model_type',
        'model_id',
        'type_ar',
        'type_en',
    ];


    protected $appends = [
        'type'
    ];


    public function getTypeAttribute()
    {
        return $this['type_' . app()->getLocale()];
    }


}
