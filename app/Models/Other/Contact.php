<?php

namespace App\Models\Other;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table ="contacts";

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'message',
        'is_read',
    ];

}
