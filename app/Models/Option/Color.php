<?php

namespace App\Models\Option;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'code',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

}
