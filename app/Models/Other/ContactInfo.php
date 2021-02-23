<?php

namespace App\Models\Other;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{

    protected $table = 'contact_info';

    protected $fillable = [
        'phones',
        'emails',
    ];

    protected $appends = [
        'phone',
        'email',
    ];


    public function setPhonesAttribute($value)
    {
        $this->attributes['phones'] = implode(',',$value);
    }

    public function setEmailsAttribute($value)
    {
        $this->attributes['emails'] = implode(',',$value);
    }

    public function getPhoneAttribute()
    {
        return explode(',',$this->phones);
    }

    public function getEmailAttribute()
    {
        return explode(',',$this->emails);
    }

}
