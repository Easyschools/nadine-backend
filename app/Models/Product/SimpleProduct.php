<?php

namespace App\Models\Product;

use App\Models\Division\Tag;
use App\Models\Feature\Collection;
use App\Models\Option\Material;
use App\Models\Order\Offer;
use App\Models\Order\OfferTag;
use App\Models\Order\OrderItem;
use Illuminate\Database\Eloquent\Model;

class SimpleProduct extends Model
{
    protected $table = 'products';

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
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Variant::class, 'product_id', 'variant_id', 'id', 'id');
    }

    public function getImageAttribute()
    {
        if (!$this->variants()->exists())
            return "";

        return $this->variants()->whereHas('images')->exists() ?
            $this->variants()->whereHas('images', function ($q) {
                $q->whereNotNull('image');
            })->first()->images()->whereNotNull('image')->first()->image
            : "";
    }

    public function getCurrencyAttribute()
    {
        return 'pound';
    }

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
