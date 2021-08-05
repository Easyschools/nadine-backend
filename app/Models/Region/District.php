<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'city_id',
    ];

    protected $appends = [
        'name',
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
