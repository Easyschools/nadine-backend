<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'additional_price',
        'color_id',
        'image',
        'product_id',
        'dimension_id',
    ];


    /**
     * @var array
     */
    protected $appends = [
        'image',
    ];

    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('User');
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Dimension()
    {
        return $this->belongsTo(Dimen::class);
    }

}


