<?php

namespace App\Models\Order;

use App\Models\Division\Tag;
use Illuminate\Database\Eloquent\Model;

class CustomTagShippingPrice extends Model
{
    protected $fillable = [
        'tag_id',
        'cost_inside_cairo',
        'cost_outside_cairo',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class , 'tag_id');
    }

}
