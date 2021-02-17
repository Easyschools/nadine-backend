<?php

namespace App\Models\Country;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
