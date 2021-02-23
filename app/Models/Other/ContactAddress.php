<?php

namespace App\Models\Other;

use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{

    protected $table = 'contact_address';

    protected $fillable =[
      'longitude',
      'latitude',
      'address',
    ];


}
