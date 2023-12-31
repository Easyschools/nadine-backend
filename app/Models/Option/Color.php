<?php

namespace App\Models\Option;

use App\Models\Product\Variant;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'code',
      'image',
    ];


    protected $appends = [
        'name'
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

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
            $this->attributes['image'] = 'uploads/' . $value->store('Color');
        }
    }
}
