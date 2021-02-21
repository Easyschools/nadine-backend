<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'stock',
        'weight',
        'price',
        'collection_id',
        'category_id',
        'dimension_id',
        'material_id',
        'tag_id',
    ];


    protected $appends = [
        'name',
        'description',
    ];


    public function getNameAttribute()
    {
        return $this['name' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this['name' . app()->getLocale()];
    }

    public function material()
    {
//        return $this->belongsTo()
    }

}
