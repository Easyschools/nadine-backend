<?php

namespace App\Models\Option;

use App\Models\Product\Variant;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $fillable =[
      'dimension',
    ];

    public function  variants(){
        return $this->hasMany(Variant::class);
    }


}
