<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'namespace' => 'Dashboard',
], function () {


    Route::group([
        'namespace' => 'Dashboard',
        'prefix' => 'admin',
    ], function () {

        Route::get('index', 'DashboardController@index');

        Route::group([
            'namespace' => 'Country',
        ], function () {
            Route::resource('countries', 'CountryController@index');
        });


    });
});
Route::get('/admin', 'HomeController@index')->name('home');
