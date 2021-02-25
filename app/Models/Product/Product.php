<?php

namespace App\Product;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Material;
use App\Models\Region\Country;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'slug',
        'stock',
        'weight',
        'price',
        'collection_id',
        'category_id',
        'tag_id',
        'dimension_id',
        'material_id',
        'tag_id',
    ];


    protected $appends = [
        'name',
        'currency',
        'image',
        'description',
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this['description_' . app()->getLocale()];
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function getImageAttribute()
    {
        return $this->variants()->first() ? $this->variants()->first()->image : "";
    }

    public function getCurrencyAttribute()
    {
        return Country::first()->currency;
    }

}
