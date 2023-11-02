<?php

namespace App\Models\Division;

use App\Models\Order\CustomTagShippingPrice;
use App\Models\Order\Offer;
use App\Models\Product\Product;
use App\Models\Product\SimpleProduct;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'category_id',
        'image',
    ];

    protected $appends = [
        'name',
    ];

    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Tag');
        }
    }

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'tag_id');
    }

    public function simpleProducts()
    {
        return $this->hasMany(SimpleProduct::class, 'tag_id');
    }

    public function customTagShippingPrice()
    {
        return $this->hasOne(CustomTagShippingPrice::class, 'tag_id');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_tags', 'tag_id', 'offer_id');
    }
}
