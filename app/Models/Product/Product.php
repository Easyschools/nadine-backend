<?php

namespace App\Models\Product;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Color;
use App\Models\Option\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'tag_id',
        'material_id',
    ];

//    protected $with = [
//        'image'
//    ];
    protected $appends = [
        'currency',
        'image',
        'type',
        'name',
        'description',
        'category',
        'category_id',
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
        return $this->belongsTo(Tag::class, 'tag_id');
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

        $variants = $this->variants;
        return count($variants) > 0 ? $variants->first()->images
            ? $variants->first()->images()->exists()
                ? $variants->first()->images()->first()->image
                : "" : "" : "";
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
                if ($variant->color) {
                    $arr[] = $variant->color->name;
                }
                if ($variant->dimension) {
                    $arr[] = $variant->dimension->dimension;
                }
            }
        }

        // add tag name of product
        if ($this->tag) {
            $arr [] = $this->tag->name;
        }

        return $arr;
    }

    public function getCategoryAttribute()
    {
        $tag = $this->tag()->with([
            'category' => function ($category) {
                $category->with('offers:id,category_id,discount,is_percentage');
            }
        ])->first();
        if ($tag)
            return $tag->category;
        return null;
    }

    public function getCategoryIdAttribute()
    {
//        dd();
        if (!Auth::check() || (Auth::check() && Auth::user()->type != 1)) return null;
        $tag = $this->tag()->with('category')->first();
        if ($tag)
            return $tag->category;
        return null;
    }

//    public function getCategoryIdAttribute()
//    {
////        dd();
//        if (!Auth::check() || (Auth::check() && Auth::user()->type != 1)) return null;
//        $tag = $this->tag()->with('category')->first();
//        if ($tag)
//            return $tag->category;
//        return null;
//    }


}
