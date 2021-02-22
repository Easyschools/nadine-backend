<?php

namespace App\Models\Division;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'category_id',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


}
