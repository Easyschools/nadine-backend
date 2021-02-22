<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
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
        return $this['name_' . app()->getLocale()];
    }

}
