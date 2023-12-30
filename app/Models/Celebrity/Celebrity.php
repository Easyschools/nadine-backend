<?php

namespace App\Models\Celebrity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebrity extends Model
{
    use HasFactory;
    protected $fillable =[
        'name_ar',
        'name_en',
        'image',
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
            $this->attributes['image'] = 'uploads/' . $value->store('Celebrity');
        }
    }
}