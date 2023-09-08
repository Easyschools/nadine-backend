<?php

namespace App\Models\Order;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_percentage',
        'discount',
        'category_id',
        'expire_at',
        'image',
    ];


    protected $appends = [
        'name',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return Carbon::instance($date)->toDateString();
    }

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function getImageAttribute($value)
    {
        return ($value) ? url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = 'uploads/' . $value->store('Offer');
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * The roles that belong to the Offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'offer_tags', 'offer_id', 'tag_id');
    }

//    public function getExpireAtAttribute()
    //    {
    //        return Carbon::createFromTimestamp($this->attributes['expire_at'])->format('l jS \\of F Y h:i:s A');
    //    }
    //
    //    public function setExpireAtAttribute($value)
    //    {
    //        $value = Carbon::createFromDate($value)->toDateTimeString();
    ////        dd($value);
    //        $this->attributes['expire_at'] = $value;
    //    }
}
