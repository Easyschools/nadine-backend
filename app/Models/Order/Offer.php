<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_percentage',
        'discount',
        'model_type',
        'model_id',
        'expire_at',
    ];


    protected $dates = [
        'expire_at'
    ];

    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name' . app()->getLocale()];
    }


}
