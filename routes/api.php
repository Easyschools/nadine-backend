<?php


Route::group([
    // 'namespace' => 'User',
    'prefix' => 'user',
],  function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('register', 'Api/Auth/AuthController@register');
        Route::post('login', 'Api\Auth\AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('forgot-password', 'AuthController@forgetPassword');
        Route::post('reset-password', 'AuthController@resetPassword');
    });
});


