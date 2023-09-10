<?php

namespace App\Models\Division;

use App\Models\Order\Offer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
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

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'category_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Tag::class, 'category_id', 'tag_id', 'id', 'id');
    }
}
