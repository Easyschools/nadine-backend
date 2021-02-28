<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'image',
    ];


    protected $appends = [
        'name'
    ];



    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Brand');
        }
    }


}
