<?php

namespace App\Models\Review;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =[
      'name',
      'email',
      'star',
      'title',
      'comment',
      'product_id',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
