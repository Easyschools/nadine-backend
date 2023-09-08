<?php

namespace App\Providers;
use App\Models\Division\Tag;
use App\Models\Feature\Brand;
use App\Models\Order\Offer;
use App\Models\Product\VariantImage;
use App\Models\User\User;
use App\Observers\BrandObserver;
use App\Observers\OfferObserver;
use App\Observers\TagObserver;
use App\Observers\UserObserver;
use App\Observers\VariantImageObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        VariantImage::observe(VariantImageObserver::class);
        Brand::observe(BrandObserver::class);
    Schema::defaultStringLength(191);

    }
}
