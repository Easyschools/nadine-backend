<?php

namespace App\Models\Option;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name' . app()->getLocale()];
    }

}
