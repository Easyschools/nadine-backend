<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable =[
      'name',
      'text',
      'image',
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
}
