<?php

namespace App\Models\Division;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

}
