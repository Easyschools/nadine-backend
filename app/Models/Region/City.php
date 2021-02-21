<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'country_id',
      'is_default',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name' . app()->getLocale()];
    }

}
