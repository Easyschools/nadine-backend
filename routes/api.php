<?php


Route::group([
    'namespace' => 'Api',
], function () {


    Route::group([
        'prefix' => 'customer',
        'namespace' => 'Auth'
    ], function () {
        Route::post('register', 'CustomerApiAuthController@register');
        Route::post('login', 'CustomerApiAuthController@login');

        Route::post('forget-password', 'CustomerApiAuthController@forgetPassword');
        Route::post('reset-password', 'CustomerApiAuthController@resetPassword');

        Route::get('check-code', 'CustomerApiAuthController@checkCode');
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
        'prefix' => 'collection',
        'namespace' => 'Feature',
    ], function () {
        Route::get('all', 'CollectionApiController@all');
        Route::get('get', 'CollectionApiController@read');
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

//    Route::group([
//        'prefix' => 'size',
//    ], function () {
//        Route::get('all', 'CategoryApiController@all');
//        Route::get('get', 'CategoryApiController@read');
//    });


});


