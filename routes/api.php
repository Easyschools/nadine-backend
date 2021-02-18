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

//    Route::group([
//        'prefix' => 'auth',
//        'namespace' => 'Auth',
//    ], function () {
//        Route::post('register', 'AuthController@register');
//        Route::post('login', 'AuthController@login');
//        Route::post('logout', 'AuthController@logout');
//        Route::post('change-password', 'AuthController@changePassword');
//        Route::post('forgot-password', 'AuthController@forgetPassword');
//        Route::post('reset-password', 'AuthController@resetPassword');
//    });


    Route::group([
        'prefix' => 'category',
    ], function () {
        Route::get('all', 'CategoryApiController@all');
    });


});


