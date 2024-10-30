<?php

namespace App\Models\Order;

use App\Models\Option\Color;
use App\Models\Option\Dimension;
use App\Models\Option\Material;
use App\Models\User\User;
use App\Models\Product\Variant;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'user_id',
        'variant_id',
        'quantity',
        'checkout',
        'color_id',
        'dimension_id',
        'material_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function dimension()
    {
        return $this->belongsTo(Dimension::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
