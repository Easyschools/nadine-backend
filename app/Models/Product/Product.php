<?php

namespace App\Models\Product;

use App\Models\Division\Category;
use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Color;
use App\Models\Option\Material;
use App\Models\Order\Offer;
use App\Models\Order\OfferTag;
use App\Models\Order\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'slug',
        'stock',
        'price',
        'price_after_discount',
        'collection_id',
        'tag_id',
        'material_id',
    ];

    protected $appends = [
        'currency',
        'image',
        'type',
        'name',
        'description',
        'category',
        'category_id',
        'active_offer',
        'price_after_offer',
        'availability',
        'gm_price',
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this['description_' . app()->getLocale()];
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function getImageAttribute()
    {
        return $this->variants()->exists() ?
            $this->variants()->whereHas('images')->exists() ?
            $this->variants()->whereHas('images', function ($q) {
                $q->whereNotNull('image');
            })->first()->images()->whereNotNull('image')->first()->image
            : "" : "";
    }

    public function getCurrencyAttribute()
    {
        return 'pound';
    }

    // public function getPriceAttribute()
    // {
    //     return $this->attributes['price_after_discount'];
    // }

    public function getPriceAfterOfferAttribute()
    {
        $tag_id = $this->tag_id;
        $offer = Offer::whereHas('tags', function ($q) use ($tag_id) {
            $q->where('tag_id', $tag_id);
        })
            ->where('expire_at', '>', now())->first();

        if ($offer) {
            if ($offer->is_percentage) {
                return $this->attributes['price'] - ($offer->discount * $this->attributes['price'] / 100);
            } else {
                return $this->attributes['price'] - $offer->discount;
            }
        }

        // return $this->attributes['price'];
    }

    public function getTypeAttribute()
    {
        return $this->category ? $this->category->name : '';
    }

    public function getTagsAttribute()
    {
        $arr = [];
        if ($this->variants()->count()) {

            foreach ($this->variants as $variant) {
                if ($variant->color) {
                    $arr[] = $variant->color->name;
                }
                if ($variant->dimension) {
                    $arr[] = $variant->dimension->dimension;
                }
            }
        }

        // add tag name of product
        if ($this->tag) {
            $arr[] = $this->tag->name;
        }

        return $arr;
    }

    public function getCategoryAttribute()
    {
        $tag = $this->tag()->with([
            'category' => function ($category) {
                $category->with('offers:id,category_id,discount,is_percentage');
            },
        ])->first();
        if ($tag) {
            return $tag->category;
        }

        return null;
    }

    public function getCategoryIdAttribute()
    {
        if (!Auth::check() || (Auth::check() && Auth::user()->type != 1)) {
            return null;
        }

        $tag = $this->tag()->with('category')->first();
        if ($tag) {
            return $tag->category;
        }

        return null;
    }

    //    public function getCategoryIdAttribute()
    //    {
    ////        dd();
    //        if (!Auth::check() || (Auth::check() && Auth::user()->type != 1)) return null;
    //        $tag = $this->tag()->with('category')->first();
    //        if ($tag)
    //            return $tag->category;
    //        return null;
    //    }

    public function getActiveOfferAttribute()
    {
        $tag_id = $this->tag_id;
        $offer = Offer::whereHas('tags', function ($q) use ($tag_id) {
            $q->where('tag_id', $tag_id);
        })
            ->where('expire_at', '>', now())->first();
        return $offer;
    }

    public function offer()
    {
        return $this->belongsTo(OfferTag::class, 'tag_id', 'tag_id')
            ->join('offers', 'offers.id', '=', 'offer_tags.offer_id');
    }

    public function getAvailabilityAttribute()
    {
        return 'in stock'; // calculate
    }
    public function getGmPriceAttribute()
    {
        return [
            'value' => $this->price,
            // 'currency' => $this->currency->code,
        ];
    }
}
