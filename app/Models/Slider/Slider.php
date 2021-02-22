<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'text',
      'image',
    ];


    /**
     * @var array
     */
    protected $appends = [
        'image',
        'name',
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
            $this->attributes['image'] = 'uploads/' . $value->store('User');
        }
    }
}
