<?php

namespace App\Models\MediaPress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaPress extends Model
{
    use HasFactory;
    protected $fillable =[
        'name_ar',
        'name_en',
        'image',
        'url',
        'type',
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
