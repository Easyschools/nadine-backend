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

        // Color::class: This parameter specifies the related model class that you are trying to access through the intermediate model (ColorVariant). In this case, it refers to the Color model.

        // ColorVariant::class: This parameter specifies the intermediate model class that connects the Variant and Color models. The ColorVariant model holds the relationships between variants and colors.

        // 'variant_id': This parameter indicates the name of the foreign key on the intermediate model (ColorVariant) that references the local key on the originating model (Variant). It establishes the relationship between Variant and ColorVariant.

        // 'id': This parameter specifies the name of the local key on the originating model (Variant). It is the primary key of the variants table.

        // 'color_variant_id': This parameter specifies the name of the foreign key on the related model (Color) that references the local key on the intermediate model (ColorVariant). It establishes the relationship between ColorVariant and Color.

        // 'color_id': This parameter specifies the name of the local key on the related model (Color). It is the primary key of the colors table.

        return $this->hasManyThrough(Color::class, ColorVariant::class, 'variant_id', 'id', 'id', 'color_id');
    }

    public function DimensionVariant()
    {
        return $this->hasManyThrough(Dimension::class, DimensionVariant::class, 'variant_id', 'id', 'id', 'dimension_id');

        // Define a one-to-many relationship with the DimensionVariant model
        // return $this->hasMany(DimensionVariant::class);
    }
}
