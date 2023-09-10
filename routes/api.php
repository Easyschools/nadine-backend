<?php

use App\Http\Controllers\Api\Auth\AdminApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\CustomerApiAuthController;
use App\Http\Controllers\Api\Auth\CustomerApiController;
use App\Http\Controllers\Api\Auth\FavouriteApiController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Api\Division\CategoryApiController;
use App\Http\Controllers\Api\Division\TagApiController;
use App\Http\Controllers\Api\Feature\BrandApiController;
use App\Http\Controllers\Api\Feature\CollectionApiController;
use App\Http\Controllers\Api\Option\ColorApiController;
use App\Http\Controllers\Api\Option\DimensionApiController;
use App\Http\Controllers\Api\Option\MaterialApiController;
use App\Http\Controllers\Api\Order\CartApiController;
use App\Http\Controllers\Api\Order\CouponApiController;
use App\Http\Controllers\Api\Order\OfferApiController;
use App\Http\Controllers\Api\Order\OrderApiController;
use App\Http\Controllers\Api\Order\OrderInfoApiController;
use App\Http\Controllers\Api\Order\OrderStatusApiController;
use App\Http\Controllers\Api\Order\UpdateOrderApiController;
use App\Http\Controllers\Api\Other\ContactApiController;
use App\Http\Controllers\Api\Other\ContactInfoApiController;
use App\Http\Controllers\Api\Payment\PaymentTypeApiController;
use App\Http\Controllers\Api\Product\ProductApiGoogleController;
use App\Http\Controllers\Api\Product\ProductApiController;
use App\Http\Controllers\Api\Product\VariantApiController;
use App\Http\Controllers\Api\Region\CityApiController;
use App\Http\Controllers\Api\Region\CountryApiController;
use App\Http\Controllers\Api\Region\DistrictApiController;
use App\Http\Controllers\Api\Review\ReviewApiController;
use App\Http\Controllers\Api\Slider\SliderApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Api',
], function () {
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Auth',
    ], function () {
        Route::post('/login', [AdminApiController::class, 'login']);
        Route::post('/logout', [AdminApiController::class, 'logout']);
    });
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('forgot-password', [AuthController::class, 'forgetPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });
});

Route::group([
    'namespace' => 'Api',
], function () {
    Route::group([
        'prefix' => 'customer',
        'namespace' => 'Auth',
    ], function () {
        Route::post('register', [CustomerApiAuthController::class, 'register']);
        Route::post('login', [CustomerApiAuthController::class, 'login']);
        Route::post('logout', [CustomerApiAuthController::class, 'logout']);

        Route::post('forget-password', [CustomerApiAuthController::class, 'forgetPassword']);
        Route::post('reset-password', [CustomerApiAuthController::class, 'resetPassword']);
        Route::post('change-password', [CustomerApiAuthController::class, 'changePassword']);

        Route::post('check-code', [CustomerApiAuthController::class, 'checkCode']);
        Route::post('confirm', [VerificationController::class, 'confirmPhone']);
        Route::post('resend-code', [VerificationController::class, 'resend']);
        Route::post('update-phone', [VerificationController::class, 'updatePhone']);

        Route::get('get', [CustomerApiController::class, 'get']);
        Route::post('update', [CustomerApiController::class, 'update']);
        Route::post('edit', [CustomerApiController::class, 'update']);
        Route::get('all', [CustomerApiController::class, 'index']);
        Route::post('delete', [CustomerApiController::class, 'delete']);
        Route::delete('delete', [CustomerApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'web/customer',
        'namespace' => 'Auth',
    ], function () {
        Route::post('register', [CustomerApiAuthController::class, 'register']);
        Route::post('login', [CustomerApiAuthController::class, 'login']);
        Route::post('logout', [CustomerApiAuthController::class, 'logout']);

        Route::post('forget-password', [CustomerApiAuthController::class, 'forgetPassword']);
        Route::post('reset-password', [CustomerApiAuthController::class, 'resetPassword']);
        Route::post('change-password', [CustomerApiAuthController::class, 'changePassword']);

        Route::post('check-code', [CustomerApiAuthController::class, 'checkCode']);
        Route::post('confirm', [VerificationController::class, 'confirmPhone']);
        Route::post('resend-code', [VerificationController::class, 'resend']);
        Route::post('update-phone', [VerificationController::class, 'updatePhone']);

        Route::get('get', [CustomerApiController::class, 'get']);
        Route::post('update', [CustomerApiController::class, 'update']);
        Route::post('edit', [CustomerApiController::class, 'update']);
        Route::get('all', [CustomerApiController::class, 'index']);
        Route::post('delete', [CustomerApiController::class, 'delete']);
        Route::delete('delete', [CustomerApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'category',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', [CategoryApiController::class, 'all']);
        Route::get('get', [CategoryApiController::class, 'read']);
        Route::delete('delete', [CategoryApiController::class, 'delete']);
        Route::post('create', [CategoryApiController::class, 'create']);
        Route::post('edit', [CategoryApiController::class, 'edit']);
    });
    Route::group([
        'prefix' => 'web/category',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', [CategoryApiController::class, 'all']);
        Route::get('get', [CategoryApiController::class, 'read']);
    });
    Route::group([
        'prefix' => 'tag',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', [TagApiController::class, 'all']);
        Route::get('get', [TagApiController::class, 'read']);
        Route::post('create', [TagApiController::class, 'create']);
        Route::post('edit', [TagApiController::class, 'edit']);
        Route::delete('delete', [TagApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'web/tag',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', [TagApiController::class, 'all']);
        Route::get('get', [TagApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'color',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', [ColorApiController::class, 'all']);
        Route::get('get', [ColorApiController::class, 'read']);
        Route::delete('delete', [ColorApiController::class, 'delete']);
        Route::post('create', [ColorApiController::class, 'create']);
        Route::post('edit', [ColorApiController::class, 'edit']);
    });
    Route::group([
        'prefix' => 'web/color',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', [ColorApiController::class, 'all']);
        Route::get('get', [ColorApiController::class, 'read']);
        Route::delete('delete', [ColorApiController::class, 'delete']);
        Route::post('create', [ColorApiController::class, 'create']);
        Route::post('edit', [ColorApiController::class, 'edit']);
    });

    Route::group([
        'prefix' => 'brand',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', [BrandApiController::class, 'all']);
        Route::get('get', [BrandApiController::class, 'read']);
        Route::post('create', [BrandApiController::class, 'create']);
        Route::post('edit', [BrandApiController::class, 'edit']);
        Route::delete('delete', [BrandApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'web/brand',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', [BrandApiController::class, 'all']);
        Route::get('get', [BrandApiController::class, 'read']);
        Route::post('create', [BrandApiController::class, 'create']);
        Route::post('edit', [BrandApiController::class, 'edit']);
        Route::delete('delete', [BrandApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'slider',
        'namespace' => 'Slider',
    ], function () {
        Route::get('all', [SliderApiController::class, 'all']);
        Route::get('get', [SliderApiController::class, 'read']);
        Route::post('create', [SliderApiController::class, 'create']);
        Route::post('edit', [SliderApiController::class, 'edit']);
        Route::delete('delete', [SliderApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'web/slider',
        'namespace' => 'Slider',
    ], function () {
        Route::get('all', [SliderApiController::class, 'all']);
        Route::get('get', [SliderApiController::class, 'read']);
        Route::post('create', [SliderApiController::class, 'create']);
        Route::post('edit', [SliderApiController::class, 'edit']);
        Route::delete('delete', [SliderApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'city',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', [CityApiController::class, 'all']);
        Route::get('get', [CityApiController::class, 'read']);
        Route::post('create', [CityApiController::class, 'create']);
        Route::post('edit', [CityApiController::class, 'edit']);
        Route::delete('delete', [CityApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'web/city',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', [CityApiController::class, 'all']);
        Route::get('get', [CityApiController::class, 'read']);
        Route::post('create', [CityApiController::class, 'create']);
        Route::post('edit', [CityApiController::class, 'edit']);
        Route::delete('delete', [CityApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'district',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', [DistrictApiController::class, 'all']);
        Route::get('get', [DistrictApiController::class, 'read']);
        Route::post('create', [DistrictApiController::class, 'create']);
        Route::post('edit', [DistrictApiController::class, 'edit']);
        Route::delete('delete', [DistrictApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'web/district',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', [DistrictApiController::class, 'all']);
        Route::get('get', [DistrictApiController::class, 'read']);
        Route::post('create', [DistrictApiController::class, 'create']);
        Route::post('edit', [DistrictApiController::class, 'edit']);
        Route::delete('delete', [DistrictApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'product',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', [ProductApiController::class, 'all']);
        Route::get('offers', [ProductApiController::class, 'offers']);
        Route::get('get', [ProductApiController::class, 'read']);
        Route::post('create', [ProductApiController::class, 'create']);
        Route::post('update', [ProductApiController::class, 'edit']);
        Route::post('edit', [ProductApiController::class, 'edit']);
        Route::delete('delete', [ProductApiController::class, 'delete']);
        Route::get('price-range', [ProductApiController::class, 'priceRange']);
        Route::get('search', [ProductApiController::class, 'search']);
    });

    Route::group([
        'prefix' => 'web/product',
        'namespace' => 'Product',
    ], function () {
        Route::post('insert', [ProductApiGoogleController::class, 'insert']);
        Route::get('list', [ProductApiGoogleController::class, 'get']);
    });

    Route::group([
        'prefix' => 'web/product',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', [ProductApiController::class, 'allWeb']);
        Route::get('get', [ProductApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'collection',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', [CollectionApiController::class, 'all']);
        Route::get('get', [CollectionApiController::class, 'read']);
        Route::delete('delete', [CollectionApiController::class, 'delete']);
        Route::post('create', [CollectionApiController::class, 'create']);
        Route::post('edit', [CollectionApiController::class, 'edit']);
    });

    Route::group([
        'prefix' => 'web/collection',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', [CollectionApiController::class, 'all']);
        Route::get('get', [CollectionApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'dimension',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', [DimensionApiController::class, 'all']);
        Route::get('get', [DimensionApiController::class, 'read']);
        Route::delete('delete', [DimensionApiController::class, 'delete']);
        Route::post('create', [DimensionApiController::class, 'create']);
        Route::post('edit', [DimensionApiController::class, 'edit']);
    });
    Route::group([
        'prefix' => 'web/dimension',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', [DimensionApiController::class, 'all']);
        Route::get('get', [DimensionApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'material',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', [MaterialApiController::class, 'all']);
        Route::get('get', [MaterialApiController::class, 'read']);
        Route::delete('delete', [MaterialApiController::class, 'delete']);
        Route::post('create', [MaterialApiController::class, 'create']);
        Route::post('edit', [MaterialApiController::class, 'edit']);
    });
    Route::group([
        'prefix' => 'web/material',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', [MaterialApiController::class, 'all']);
        Route::get('get', [MaterialApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'variant',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', [VariantApiController::class, 'all']);
        Route::get('get', [VariantApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'web/variant',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', [VariantApiController::class, 'all']);
        Route::get('get', [VariantApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'coupon',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', [CouponApiController::class, 'all']);
        Route::get('get', [CouponApiController::class, 'read']);
        Route::delete('delete', [CouponApiController::class, 'delete']);
        Route::post('create', [CouponApiController::class, 'create']);
        Route::post('edit', [CouponApiController::class, 'edit']);
    });

    Route::group([
        'prefix' => 'web/coupon',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', [CouponApiController::class, 'all']);
        Route::get('get', [CouponApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'offer',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', [OfferApiController::class, 'all']);
        Route::get('get', [OfferApiController::class, 'read']);
        Route::delete('delete', [OfferApiController::class, 'delete']);
        Route::post('create', [OfferApiController::class, 'create']);
        Route::post('edit', [OfferApiController::class, 'edit']);
    });
    Route::group([
        'prefix' => 'web/offer',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', [OfferApiController::class, 'all']);
        Route::get('get', [OfferApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'order-status',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', [OrderStatusApiController::class, 'all']);
        Route::get('get', [OrderStatusApiController::class, 'read']);
        Route::delete('delete', [OrderStatusApiController::class, 'delete']);
        Route::post('create', [OrderStatusApiController::class, 'create']);
        Route::post('edit', [OrderStatusApiController::class, 'edit']);
    });

    Route::group([
        'prefix' => 'web/order-status',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', [OrderStatusApiController::class, 'all']);
        Route::get('get', [OrderStatusApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'country',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', [CountryApiController::class, 'all']);
        Route::get('get', [CountryApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'web/country',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', [CountryApiController::class, 'all']);
        Route::get('get', [CountryApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'review',
        'namespace' => 'Review',
    ], function () {
        Route::get('all', [ReviewApiController::class, 'all']);
        Route::get('get', [ReviewApiController::class, 'read']);
        Route::post('create', [ReviewApiController::class, 'create']);
        Route::post('update', [ReviewApiController::class, 'update']);
        Route::post('edit', [ReviewApiController::class, 'update']);
        Route::get('delete', [ReviewApiController::class, 'delete']);
        Route::delete('delete', [ReviewApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'web/review',
        'namespace' => 'Review',
    ], function () {
        Route::get('all', [ReviewApiController::class, 'all']);
        Route::get('get', [ReviewApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'favourite',
        'namespace' => 'Auth',
    ], function () {
        Route::get('all', [FavouriteApiController::class, 'all']);
        Route::get('get', [FavouriteApiController::class, 'read']);
        Route::post('create', [FavouriteApiController::class, 'create']);
        Route::get('delete', [FavouriteApiController::class, 'delete']);
        Route::delete('delete', [FavouriteApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'web/favourite',
        'namespace' => 'Auth',
    ], function () {
        Route::get('all', [FavouriteApiController::class, 'all']);
        Route::get('get', [FavouriteApiController::class, 'read']);
    });

    Route::group([
        'prefix' => 'contact-info',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', [ContactInfoApiController::class, 'all']);
        Route::get('index', [ContactInfoApiController::class, 'index']);
        Route::get('get', [ContactInfoApiController::class, 'read']);
        Route::post('create', [ContactInfoApiController::class, 'create']);
        Route::post('update', [ContactInfoApiController::class, 'update']);
        Route::post('edit', [ContactInfoApiController::class, 'update']);
        Route::get('delete', [ContactInfoApiController::class, 'delete']);
        Route::delete('delete', [ContactInfoApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'web/contact-info',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', [ContactInfoApiController::class, 'all']);
        Route::get('get', [ContactInfoApiController::class, 'read']);
    });
    Route::group([
        'prefix' => 'contact',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', [ContactApiController::class, 'all']);
        Route::get('get', [ContactApiController::class, 'read']);
        Route::post('create', [ContactApiController::class, 'create']);
        Route::delete('delete', [ContactApiController::class, 'delete']);
        Route::get('get-count-unread', [ContactApiController::class, 'getCountOfunRead']);
    });
    Route::group([
        'prefix' => 'web/contact',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', [ContactApiController::class, 'all']);
        Route::get('get', [ContactApiController::class, 'read']);
        Route::post('create', [ContactApiController::class, 'create']);
        Route::delete('delete', [ContactApiController::class, 'delete']);
        Route::get('get-count-unread', [ContactApiController::class, 'getCountOfunRead']);
    });

    Route::group([
        'prefix' => 'payment-type',
        'namespace' => 'Payment',
    ], function () {
        Route::get('all', [PaymentTypeApiController::class, 'all']);
        Route::get('get', [PaymentTypeApiController::class, 'read']);
        Route::post('create', [PaymentTypeApiController::class, 'create']);
        Route::post('update', [PaymentTypeApiController::class, 'update']);
        Route::post('edit', [PaymentTypeApiController::class, 'update']);
        Route::get('delete', [PaymentTypeApiController::class, 'delete']);
        Route::delete('delete', [PaymentTypeApiController::class, 'delete']);
    });
    Route::group([
        'prefix' => 'web/payment-type',
        'namespace' => 'Payment',
    ], function () {
        Route::get('all', [PaymentTypeApiController::class, 'all']);
        Route::get('get', [PaymentTypeApiController::class, 'read']);
        Route::post('create', [PaymentTypeApiController::class, 'create']);
        Route::post('update', [PaymentTypeApiController::class, 'update']);
        Route::post('edit', [PaymentTypeApiController::class, 'update']);
        Route::get('delete', [PaymentTypeApiController::class, 'delete']);
        Route::delete('delete', [PaymentTypeApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'cart',
        'namespace' => 'Order',
    ], function () {
        Route::post('add-to-cart', [CartApiController::class, 'addToCart']);
        Route::post('delete', [CartApiController::class, 'delete']);
        Route::delete('delete', [CartApiController::class, 'delete']);
        Route::post('update', [CartApiController::class, 'update']);
        Route::post('edit', [CartApiController::class, 'update']);
        Route::get('all', [CartApiController::class, 'index']);
    });

    Route::group([
        'prefix' => 'web/cart',
        'namespace' => 'Order',
    ], function () {
        Route::post('add-to-cart', [CartApiController::class, 'addToCart']);
        Route::post('delete', [CartApiController::class, 'delete']);
        Route::delete('delete', [CartApiController::class, 'delete']);
        Route::post('update', [CartApiController::class, 'update']);
        Route::post('edit', [CartApiController::class, 'update']);
        Route::get('all', [CartApiController::class, 'index']);
    });

    Route::group([
        'prefix' => 'order',
        'namespace' => 'Order',
    ], function () {
        Route::post('/status', [OrderApiController::class, 'updateStatus']);
        Route::get('/calculate', [OrderApiController::class, 'calculate']);
        Route::get('/grand-total', [OrderApiController::class, 'grandTotal']);
        Route::post('/checkout', [OrderApiController::class, 'checkout']);

        Route::post('/update', [UpdateOrderApiController::class, 'update']);

        Route::get('/get-orders', [OrderInfoApiController::class, 'getUserOrders']);
        Route::get('/order-details', [OrderInfoApiController::class, 'orderDetails']);
        Route::get('/', [OrderInfoApiController::class, 'allOrders']);
        Route::get('/search', [OrderInfoApiController::class, 'search']);
        Route::delete('/delete', [OrderApiController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'web/order',
        'namespace' => 'Order',
    ], function () {
        Route::post('/status', [OrderApiController::class, 'updateStatus']);
        Route::get('/calculate', [OrderApiController::class, 'calculate']);
        Route::get('/grand-total', [OrderApiController::class, 'grandTotal']);
        Route::post('/checkout', [OrderApiController::class, 'checkout']);

        Route::post('/update', [UpdateOrderApiController::class, 'update']);

        Route::get('/get-orders', [OrderInfoApiController::class, 'getUserOrders']);
        Route::get('/order-details', [OrderInfoApiController::class, 'orderDetails']);
        Route::get('/', [OrderInfoApiController::class, 'allOrders']);
        Route::get('/search', [OrderInfoApiController::class, 'search']);
        Route::delete('/delete', [OrderApiController::class, 'delete']);
    });
});
