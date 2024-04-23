<?php

namespace App\Models\Product;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Option\Material;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            // dd($value);

            $this->attributes['image'] = 'uploads/' . $value->store('Slider');
        }else {
            $baseUrl = env('APP_URL'); // Retrieve the base URL from the .env file

            $imagePath = str_replace($baseUrl, '', $value);
            // dd($imagePath);

            $this->attributes['image'] = $imagePath;
            
        }
    }

    
}
