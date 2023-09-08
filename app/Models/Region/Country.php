<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'code',
        'name_ar',
        'name_en',
        'currency',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }


    /**
     * @return string
     */
    public function getForeignKey()
    {
        return 'country_id';
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
