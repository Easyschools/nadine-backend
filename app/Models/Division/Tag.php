<?php

namespace App\Models\Division;

use App\Models\Order\Offer;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'category_id',
        'image',
    ];


    protected $appends = [
        'name'
    ];


    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Tag');
        }
    }

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
