<?php

namespace App\Models\Product;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Option\Material;
use Illuminate\Database\Eloquent\Model;

class ColorVariant extends Model
{
    protected $fillable = [
        'color_id',
        'variant_id',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }


    public function Color()
    {
//        return $this->belongsTo(Color::class , 'color_id');
        return $this->belongsTo(Color::class);
    }
    
}
