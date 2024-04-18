<?php

namespace App\Models\Product;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Option\Material;
use Illuminate\Database\Eloquent\Model;

class DimensionVariant extends Model
{
    protected $fillable = [
        'dimension_id',
        'variant_id',
    ];

   

    public function Dimension()
    {
        return $this->belongsTo(Dimension::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    
}
