<?php



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
    Route::group([
        'prefix' => '/',
    ], function () {
        Route::get('/', 'UserController@index');
        Route::get('/get', 'UserController@read');
        Route::get('/get-by-slug', 'UserController@readBySlug');
        Route::post('/update-slug', 'UserController@updateSlug');
        Route::get('/hash-token', 'UserController@hashToken');
        Route::post('/create', 'UserController@create');
        Route::post('/update', 'UserController@update');
        Route::post('/delete', 'UserController@delete');
        Route::post('/add-socials', 'UserController@addSocials');
        Route::post('/delete-social', 'UserController@deleteSocial');
        Route::post('/upload-file', 'UserController@uploadFiles');
        Route::post('/delete-file', 'UserController@deleteFile');
        Route::post('/add-address', 'UserController@addAddress');
        Route::post('/delete-address', 'UserController@deleteAddress');
        Route::post('/update-address', 'UserController@updateAddress');
        Route::get('/get-addresses', 'UserController@getUserAddresses');
    });
});


Route::group([
    'namespace' => 'Api',
], function () {


    Route::group([
        'prefix' => 'customer',
        'namespace' => 'Auth'
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
        'prefix' => 'tag',
        'namespace' => 'Division',
    ], function () {
        Route::get('all', 'TagApiController@all');
        Route::get('get', 'TagApiController@read');
        Route::post('create', 'TagApiController@create');
        Route::post('edit', 'TagApiController@edit');
    });


    Route::group([
        'prefix' => 'color',
        'namespace' => 'Option',
    ], function () {
        Route::get('all', 'ColorApiController@all');
        Route::get('get', 'ColorApiController@read');
    });


    Route::group([
        'prefix' => 'brand',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', 'BrandApiController@all');
        Route::get('get', 'BrandApiController@read');
    });


    Route::group([
        'prefix' => 'slider',
        'namespace' => 'Slider',
    ], function () {
        Route::get('all', 'SliderApiController@all');
        Route::get('get', 'SliderApiController@read');
    });

    Route::group([
        'prefix' => 'city',
        'namespace' => 'Region',
    ], function () {
        Route::get('all', 'CityApiController@all');
        Route::get('get', 'CityApiController@read');
    });

    Route::group([
        'prefix' => 'product',
        'namespace' => 'Product',
    ], function () {
        Route::get('all', 'ProductApiController@all');
        Route::get('get', 'ProductApiController@read');
    });


    Route::group([
        'prefix' => 'collection',
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
    });


    Route::group([
        'prefix' => 'material',
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
        'prefix' => 'coupon',
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
    });

    Route::group([
        'prefix' => 'order-status',
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
        'prefix' => 'favourite',
        'namespace' => 'Auth',
    ], function () {
        Route::get('all', 'FavouriteApiController@all');
        Route::get('get', 'FavouriteApiController@read');
        Route::post('create', 'FavouriteApiController@create');
        Route::get('delete', 'FavouriteApiController@delete');
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
        'prefix' => 'contact',
        'namespace' => 'Other',
    ], function () {
        Route::get('all', 'ContactApiController@all');
        Route::get('get', 'ContactApiController@read');
        Route::post('create', 'ContactApiController@create');
        Route::get('delete', 'ContactApiController@delete');
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
        'prefix' => 'cart',
        'namespace' => 'Order'
    ], function () {
        Route::post('add-to-cart', 'CartApiController@create');
        Route::post('delete', 'CartApiController@delete');
        Route::get('all', 'CartApiController@index');
    });


    Route::group([
        'prefix' => 'order',
        'namespace' => 'Order'
    ], function () {
        Route::post('/status', 'OrderApiController@updateStatus');
        Route::get('/calculate', 'OrderApiController@calculate');
        Route::get('/grand-total', 'OrderApiController@grandTotal');
        Route::post('/checkout', 'OrderApiController@checkout');


        Route::get('/get-orders', 'OrderInfoApiController@getUserOrders');
        Route::get('/order-details', 'OrderInfoApiController@orderDetails');
        Route::get('/', 'OrderInfoApiController@allOrders');
        Route::get('/search', 'OrderInfoApiController@search');
        Route::post('/delete', 'OrderApiController@delete');
    });

});


