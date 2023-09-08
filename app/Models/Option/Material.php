<?php

namespace App\Models\Option;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
