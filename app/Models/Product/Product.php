<?php

namespace App\Models\Product;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Color;
use App\Models\Option\Material;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'slug',
        'stock',
        'price',
        'price_after_discount',
        'collection_id',
        'category_id',
        'tag_id',
        'material_id',
        'tag_id',
    ];


    protected $appends = [
        'currency',
        'image',
        'type',
        'name',
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
        return 'pound';
    }

    public function getTypeAttribute()
    {
        return $this->category ? $this->category->name : '';
    }

    public function getTagsAttribute()
    {
        $arr = [];
        if ($this->variants()->count()) {

            foreach ($this->variants as $variant) {
                $arr[] = $variant->color->name;
                $arr[] = $variant->dimension->dimension;
            }
        }

        // add tags of which has products
        $arr = array_merge($arr,
            Tag::whereHas('products', function ($q) {
                $q->select('name_en', 'name_ar', 'id');
            })->pluck('name_' . app()->getLocale())->toArray());

        return $arr;
    }


}
