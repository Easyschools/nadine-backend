<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    // use HasFactory;
    // protected $table = "product_details";
    // protected $fillable = ['details', 'image', 'product_id'];

    // public function getImageAttribute($value)
    // {
    //     return ($value) ? url($value) : $value;
    // }

    // public function setImageAttribute($value)
    // {
    //     if (!is_array($value)) {
    //         if (is_file($value))
    //             $this->attributes['image'] = 'uploads/' . $value->store('detailes');
    //     }
    // }

   
}
