<?php

namespace App\Providers;
use App\Models\Division\Tag;
use App\Models\Feature\Brand;
use App\Models\Order\Offer;
use App\Models\Product\Variant;
use App\Models\User\User;
use App\Observers\BrandObserver;
use App\Observers\OfferObserver;
use App\Observers\TagObserver;
use App\Observers\UserObserver;
use App\Observers\VariantObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        User::observe(UserObserver::class);
        Tag::observe(TagObserver::class);
        Offer::observe(OfferObserver::class);
        Variant::observe(VariantObserver::class);
        Brand::observe(BrandObserver::class);
    }
}
