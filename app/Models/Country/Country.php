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
     * @var string
     */
    protected $table = 'countries';


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

//    public function cities()
//    {
//
//    }
}
