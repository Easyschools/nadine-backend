<?php

namespace App\Models\Feature;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'image',
    ];


    protected $appends = [
        'name'
    ];


    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Collection');
        }
    }


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
