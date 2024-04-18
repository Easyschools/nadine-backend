<?php

namespace App\Models\Product;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Option\Material;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'additional_price',
        'color_id',
        'product_id',
        'dimension_id',
        'material_id',
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

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function ColorVariant()
    {
        // return $this->hasMany(ColorVariant::class);

        // Define a one-to-many relationship with the ColorVariant model

        return $this->hasManyThrough(Color::class, ColorVariant::class, 'variant_id', 'id', 'id', 'color_id');
    }

    public function DimensionVariant()
    {
        return $this->hasManyThrough(Dimension::class, DimensionVariant::class, 'variant_id', 'id', 'id', 'dimension_id');

        // Define a one-to-many relationship with the DimensionVariant model
        // return $this->hasMany(DimensionVariant::class);
    }
}
