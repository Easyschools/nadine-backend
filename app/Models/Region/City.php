<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = [
        'name_ar',
        'name_en',
        'shipping_cost',
    ];

    protected $appends = [
        'name',
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
