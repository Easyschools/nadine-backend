<?php

namespace App\Models\Product;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use Illuminate\Database\Eloquent\Model;

class VariantImage extends Model
{
    protected $fillable = [
        'image',
        'variant_id',
    ];


    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    // public function setImageAttribute($value)
    // {
    //     if (!is_array($value)) {
    //         if (is_file($value))
    //             $this->attributes['image'] = 'uploads/' . $value->store('Variant');
    //     }
    // }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }


}


