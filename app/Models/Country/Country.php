<?php

namespace App\Models\Country;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Country extends Model
{
    use Translatable ;

    /**
     * The translated attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name'
    ];


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations'
    ];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'code',
        'is_default',
    ];

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return 'country_id';
    }

}
