<?php

namespace App\Models\Country;

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
        'is_default',
    ];


    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        return $this['name' . app()->getLocale()];
    }


    /**
     * @return string
     */
    public function getForeignKey()
    {
        return 'country_id';
    }

}
