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
        'image',
        'stock',
        'product_id',
        'dimension_id',
    ];


    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Variant');
        }
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
        return $this->belongsTo(Color::class);
    }

}


