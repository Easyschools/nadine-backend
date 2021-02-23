<?php

namespace App\Models\Order;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_percentage',
        'discount',
        'model_type',
        'model_id',
        'expire_at',
        'image',
    ];


    protected $dates = [
        'expire_at'
    ];

    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Offer');
        }
    }

    public function category()
    {
        if ($this->model_type == 'Category') {
            return $this->belongsTo(Category::class, 'model_id');
        } else {
            return $this->belongsTo(Tag::class, 'model_id');

        }
    }


}
