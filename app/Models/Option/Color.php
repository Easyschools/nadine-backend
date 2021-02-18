<?php

namespace App\Models\Option;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable =[
      'name_ar',
      'name_en',
      'code',
    ];
}
