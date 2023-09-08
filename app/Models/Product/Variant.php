<?php

namespace App\Models\Product;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'additional_price',
        'color_id',
        'product_id',
        'dimension_id',
    ];

    protected $appends = [
        'image',
    ];

    public function getImageAttribute($value)
    {
        $image = $this->images()->first();
        return $image ? url($image->image) : '';
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Dimension()
    {
        return $this->belongsTo(Dimension::class);
    }

    public function Color()
    {
//        return $this->belongsTo(Color::class , 'color_id');
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->hasMany(VariantImage::class);
    }

}
