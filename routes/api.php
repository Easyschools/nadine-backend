<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Api',
], function () {
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Auth',
    ], function () {
        Route::post('/login', 'AdminApiController@login');
        Route::post('/logout', 'AdminApiController@logout');
    });
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('forgot-password', 'AuthController@forgetPassword');
        Route::post('reset-password', 'AuthController@resetPassword');
    });
});

Route::group([
    'namespace' => 'Api',
], function () {
    Route::group([
        'prefix' => 'customer',
        'namespace' => 'Auth',
    ], function () {
        Route::post('register', 'CustomerApiAuthController@register');
        Route::post('login', 'CustomerApiAuthController@login');
        Route::post('logout', 'CustomerApiAuthController@logout');

        Route::post('forget-password', 'CustomerApiAuthController@forgetPassword');
        Route::post('reset-password', 'CustomerApiAuthController@resetPassword');
        Route::post('change-password', 'CustomerApiAuthController@changePassword');

        Route::post('check-code', 'CustomerApiAuthController@checkCode');
        Route::post('confirm', 'VerificationController@confirmPhone');
        Route::post('resend-code', 'VerificationController@resend');
        Route::post('update-phone', 'VerificationController@updatePhone');

        Route::get('get', 'CustomerApiController@get');
        Route::post('update', 'CustomerApiController@update');
        Route::get('all', 'CustomerApiController@index');
        Route::post('delete', 'CustomerApiController@delete');
    });
    Route::group([
        'prefix' => 'web/customer',
        'namespace' => 'Auth',
    ], function () {
        Route::post('register', 'CustomerApiAuthController@register');
        Route::post('login', 'CustomerApiAuthController@login');
        Route::post('logout', 'CustomerApiAuthController@logout');

        Route::post('forget-password', 'CustomerApiAuthController@forgetPassword');
        Route::post('reset-password', 'CustomerApiAuthController@resetPassword');
        Route::post('change-password', 'CustomerApiAuthController@changePassword');

        Route::post('check-code', 'CustomerApiAuthController@checkCode');
        Route::post('confirm', 'VerificationController@confirmPhone');
        Route::post('resend-code', 'VerificationController@resend');
        Route::post('update-phone', 'VerificationController@updatePhone');

        Route::get('get', 'CustomerApiController@get');
        Route::post('update', 'CustomerApiController@update');
        Route::get('all', 'CustomerApiController@index');
        Route::post('delete', 'CustomerApiController@delete');
    });

    Route::group([
        'prefix' => 'category',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', 'CategoryApiController@all');
        Route::get('get', 'CategoryApiController@read');
        Route::delete('delete', 'CategoryApiController@delete');
        Route::post('create', 'CategoryApiController@create');
        Route::post('edit', 'CategoryApiController@edit');
    });
    Route::group([
        'prefix' => 'web/category',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', 'CategoryApiController@all');
        Route::get('get', 'CategoryApiController@read');
    });
    Route::group([
        'prefix' => 'tag',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', 'TagApiController@all');
        Route::get('get', 'TagApiController@read');
        Route::post('create', 'TagApiController@create');
        Route::post('edit', 'TagApiController@edit');
        Route::delete('delete', 'TagApiController@delete');
    });

    Route::group([
        'prefix' => 'web/tag',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', 'TagApiController@all');
        Route::get('get', 'TagApiController@read');
    });

    Route::group([
        'prefix' => 'color',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'ColorApiController@all');
        Route::get('get', 'ColorApiController@read');
        Route::delete('delete', 'ColorApiController@delete');
        Route::post('create', 'ColorApiController@create');
        Route::post('edit', 'ColorApiController@edit');
    });
    Route::group([
        'prefix' => 'web/color',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'ColorApiController@all');
        Route::get('get', 'ColorApiController@read');
        Route::delete('delete', 'ColorApiController@delete');
        Route::post('create', 'ColorApiController@create');
        Route::post('edit', 'ColorApiController@edit');
    });

    Route::group([
        'prefix' => 'brand',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', 'BrandApiController@all');
        Route::get('get', 'BrandApiController@read');
        Route::post('create', 'BrandApiController@create');
        Route::post('edit', 'BrandApiController@edit');
        Route::delete('delete', 'BrandApiController@delete');
    });
    Route::group([
        'prefix' => 'web/brand',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', 'BrandApiController@all');
        Route::get('get', 'BrandApiController@read');
        Route::post('create', 'BrandApiController@create');
        Route::post('edit', 'BrandApiController@edit');
        Route::delete('delete', 'BrandApiController@delete');
    });
    Route::group([
        'prefix' => 'slider',
        'namespace' => 'Slider',
    ], function () {
        Route::get('all', 'SliderApiController@all');
        Route::get('get', 'SliderApiController@read');
        Route::post('create', 'SliderApiController@create');
        Route::post('edit', 'SliderApiController@edit');
        Route::delete('delete', 'SliderApiController@delete');
    });
    Route::group([
        'prefix' => 'web/slider',
        'namespace' => 'Slider',
    ], function () {
        Route::get('all', 'SliderApiController@all');
        Route::get('get', 'SliderApiController@read');
        Route::post('create', 'SliderApiController@create');
        Route::post('edit', 'SliderApiController@edit');
        Route::delete('delete', 'SliderApiController@delete');
    });

    Route::group([
        'prefix' => 'city',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'CityApiController@all');
        Route::get('get', 'CityApiController@read');
        Route::post('create', 'CityApiController@create');
        Route::post('edit', 'CityApiController@edit');
        Route::delete('delete', 'CityApiController@delete');
    });
    Route::group([
        'prefix' => 'web/city',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'CityApiController@all');
        Route::get('get', 'CityApiController@read');
        Route::post('create', 'CityApiController@create');
        Route::post('edit', 'CityApiController@edit');
        Route::delete('delete', 'CityApiController@delete');
    });

    Route::group([
        'prefix' => 'district',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'DistrictApiController@all');
        Route::get('get', 'DistrictApiController@read');
        Route::post('create', 'DistrictApiController@create');
        Route::post('edit', 'DistrictApiController@edit');
        Route::delete('delete', 'DistrictApiController@delete');
    });
    Route::group([
        'prefix' => 'web/district',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'DistrictApiController@all');
        Route::get('get', 'DistrictApiController@read');
        Route::post('create', 'DistrictApiController@create');
        Route::post('edit', 'DistrictApiController@edit');
        Route::delete('delete', 'DistrictApiController@delete');
    });

    Route::group([
        'prefix' => 'product',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', 'ProductApiController@all');
        Route::get('offers', 'ProductApiController@offers');
        Route::get('get', 'ProductApiController@read');
        Route::post('create', 'ProductApiController@create');
        Route::post('update', 'ProductApiController@edit');
        Route::delete('delete', 'ProductApiController@delete');
        Route::get('price-range', 'ProductApiController@priceRange');
    });


    Route::group([
        'prefix' => 'web/product',
        'namespace' => 'Product',
    ], function () {
        Route::post('insert', 'ProductApiGoogleController@insert');
        Route::get('list', 'ProductApiGoogleController@get');
    });

    Route::group([
        'prefix' => 'web/product',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', 'ProductApiController@allWeb');
        Route::get('get', 'ProductApiController@read');
    });

    Route::group([
        'prefix' => 'collection',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', 'CollectionApiController@all');
        Route::get('get', 'CollectionApiController@read');
        Route::delete('delete', 'CollectionApiController@delete');
        Route::post('create', 'CollectionApiController@create');
        Route::post('edit', 'CollectionApiController@edit');
    });

    Route::group([
        'prefix' => 'web/collection',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', 'CollectionApiController@all');
        Route::get('get', 'CollectionApiController@read');
    });

    Route::group([
        'prefix' => 'dimension',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'DimensionApiController@all');
        Route::get('get', 'DimensionApiController@read');
        Route::delete('delete', 'DimensionApiController@delete');
        Route::post('create', 'DimensionApiController@create');
        Route::post('edit', 'DimensionApiController@edit');
    });
    Route::group([
        'prefix' => 'web/dimension',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'DimensionApiController@all');
        Route::get('get', 'DimensionApiController@read');
    });


    Route::group([
        'prefix' => 'material',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'MaterialApiController@all');
        Route::get('get', 'MaterialApiController@read');
        Route::delete('delete', 'MaterialApiController@delete');
        Route::post('create', 'MaterialApiController@create');
        Route::post('edit', 'MaterialApiController@edit');
    });
    Route::group([
        'prefix' => 'web/material',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'MaterialApiController@all');
        Route::get('get', 'MaterialApiController@read');
    });

    Route::group([
        'prefix' => 'variant',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', 'VariantApiController@all');
        Route::get('get', 'VariantApiController@read');
    });


    Route::group([
        'prefix' => 'web/variant',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', 'VariantApiController@all');
        Route::get('get', 'VariantApiController@read');
    });

    Route::group([
        'prefix' => 'coupon',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', 'CouponApiController@all');
        Route::get('get', 'CouponApiController@read');
        Route::delete('delete', 'CouponApiController@delete');
        Route::post('create', 'CouponApiController@create');
        Route::post('edit', 'CouponApiController@edit');
    });

    Route::group([
        'prefix' => 'web/coupon',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', 'CouponApiController@all');
        Route::get('get', 'CouponApiController@read');
    });


    Route::group([
        'prefix' => 'offer',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', 'OfferApiController@all');
        Route::get('get', 'OfferApiController@read');
        Route::delete('delete', 'OfferApiController@delete');
        Route::post('create', 'OfferApiController@create');
        Route::post('edit', 'OfferApiController@edit');
    });
    Route::group([
        'prefix' => 'web/offer',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', 'OfferApiController@all');
        Route::get('get', 'OfferApiController@read');
    });

    Route::group([
        'prefix' => 'order-status',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', 'OrderStatusApiController@all');
        Route::get('get', 'OrderStatusApiController@read');
        Route::delete('delete', 'OrderStatusApiController@delete');
        Route::post('create', 'OrderStatusApiController@create');
        Route::post('edit', 'OrderStatusApiController@edit');
    });

    Route::group([
        'prefix' => 'web/order-status',
        'namespace' => 'Order',
    ], function () {
        Route::get('all', 'OrderStatusApiController@all');
        Route::get('get', 'OrderStatusApiController@read');
    });

    Route::group([
        'prefix' => 'country',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'CountryApiController@all');
        Route::get('get', 'CountryApiController@read');
    });

    Route::group([
        'prefix' => 'web/country',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'CountryApiController@all');
        Route::get('get', 'CountryApiController@read');
    });

    Route::group([
        'prefix' => 'review',
        'namespace' => 'Review',
    ], function () {
        Route::get('all', 'ReviewApiController@all');
        Route::get('get', 'ReviewApiController@read');
        Route::post('create', 'ReviewApiController@create');
        Route::post('update', 'ReviewApiController@update');
        Route::get('delete', 'ReviewApiController@delete');
    });

    Route::group([
        'prefix' => 'web/review',
        'namespace' => 'Review',
    ], function () {
        Route::get('all', 'ReviewApiController@all');
        Route::get('get', 'ReviewApiController@read');
    });

    Route::group([
        'prefix' => 'favourite',
        'namespace' => 'Auth',
    ], function () {
        Route::get('all', 'FavouriteApiController@all');
        Route::get('get', 'FavouriteApiController@read');
        Route::post('create', 'FavouriteApiController@create');
        Route::get('delete', 'FavouriteApiController@delete');
    });

    Route::group([
        'prefix' => 'web/favourite',
        'namespace' => 'Auth',
    ], function () {
        Route::get('all', 'FavouriteApiController@all');
        Route::get('get', 'FavouriteApiController@read');
    });


    Route::group([
        'prefix' => 'contact-info',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', 'ContactInfoApiController@all');
        Route::get('get', 'ContactInfoApiController@read');
        Route::post('create', 'ContactInfoApiController@create');
        Route::post('update', 'ContactInfoApiController@update');
        Route::get('delete', 'ContactInfoApiController@delete');
    });

    Route::group([
        'prefix' => 'web/contact-info',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', 'ContactInfoApiController@all');
        Route::get('get', 'ContactInfoApiController@read');
    });
    Route::group([
        'prefix' => 'contact',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', 'ContactApiController@all');
        Route::get('get', 'ContactApiController@read');
        Route::post('create', 'ContactApiController@create');
        Route::delete('delete', 'ContactApiController@delete');
        Route::get('get-count-unread', 'ContactApiController@getCountOfunRead');
    });
    Route::group([
        'prefix' => 'web/contact',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', 'ContactApiController@all');
        Route::get('get', 'ContactApiController@read');
        Route::post('create', 'ContactApiController@create');
        Route::delete('delete', 'ContactApiController@delete');
        Route::get('get-count-unread', 'ContactApiController@getCountOfunRead');
    });

    Route::group([
        'prefix' => 'payment-type',
        'namespace' => 'Payment',
    ], function () {
        Route::get('all', 'PaymentTypeApiController@all');
        Route::get('get', 'PaymentTypeApiController@read');
        Route::post('create', 'PaymentTypeApiController@create');
        Route::post('update', 'PaymentTypeApiController@update');
        Route::get('delete', 'PaymentTypeApiController@delete');
    });
    Route::group([
        'prefix' => 'web/payment-type',
        'namespace' => 'Payment',
    ], function () {
        Route::get('all', 'PaymentTypeApiController@all');
        Route::get('get', 'PaymentTypeApiController@read');
        Route::post('create', 'PaymentTypeApiController@create');
        Route::post('update', 'PaymentTypeApiController@update');
        Route::get('delete', 'PaymentTypeApiController@delete');
    });

    Route::group([
        'prefix' => 'cart',
        'namespace' => 'Order',
    ], function () {
        Route::post('add-to-cart', 'CartApiController@addToCart');
        Route::post('delete', 'CartApiController@delete');
        Route::post('update', 'CartApiController@update');
        Route::get('all', 'CartApiController@index');
    });

    Route::group([
        'prefix' => 'web/cart',
        'namespace' => 'Order',
    ], function () {
        Route::post('add-to-cart', 'CartApiController@addToCart');
        Route::post('delete', 'CartApiController@delete');
        Route::post('update', 'CartApiController@update');
        Route::get('all', 'CartApiController@index');
    });

    Route::group([
        'prefix' => 'order',
        'namespace' => 'Order',
    ], function () {
        Route::post('/status', 'OrderApiController@updateStatus');
        Route::get('/calculate', 'OrderApiController@calculate');
        Route::get('/grand-total', 'OrderApiController@grandTotal');
        Route::post('/checkout', 'OrderApiController@checkout');

        Route::post('/update', 'UpdateOrderApiController@update');

        Route::get('/get-orders', 'OrderInfoApiController@getUserOrders');
        Route::get('/order-details', 'OrderInfoApiController@orderDetails');
        Route::get('/', 'OrderInfoApiController@allOrders');
        Route::get('/search', 'OrderInfoApiController@search');
        Route::delete('/delete', 'OrderApiController@delete');
    });

    Route::group([
        'prefix' => 'web/order',
        'namespace' => 'Order',
    ], function () {
        Route::post('/status', 'OrderApiController@updateStatus');
        Route::get('/calculate', 'OrderApiController@calculate');
        Route::get('/grand-total', 'OrderApiController@grandTotal');
        Route::post('/checkout', 'OrderApiController@checkout');

        Route::post('/update', 'UpdateOrderApiController@update');

        Route::get('/get-orders', 'OrderInfoApiController@getUserOrders');
        Route::get('/order-details', 'OrderInfoApiController@orderDetails');
        Route::get('/', 'OrderInfoApiController@allOrders');
        Route::get('/search', 'OrderInfoApiController@search');
        Route::delete('/delete', 'OrderApiController@delete');
    });
});
