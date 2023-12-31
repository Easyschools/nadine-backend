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

// Route::get('test', function () {
//     $order = Order::first();
//     return view('email.Order', compact('order'));
// });
Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::group([
    'prefix' => 'admin',
], function () {

    Route::get('{any?}', function () {
        return view('index');
    })
        ->where('any', '^(?!(api|xyz).*$).*');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
