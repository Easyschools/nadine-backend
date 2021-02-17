<?php

namespace App\Models\Country;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{

    protected $table = 'country_translations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'country_id',
        'locale'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
