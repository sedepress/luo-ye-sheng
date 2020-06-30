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

Route::any('/', 'IndexController@index');
Route::group(['prefix' => 'shop'], function() {
    Route::get('/', 'ShopController@index');
    Route::get('/list', 'ShopController@list')->name('shop.list');
    Route::post('/pay', 'ShopController@pay')->name('shop.pay');
});

Route::group(['prefix' => 'user'], function() {
    Route::get('/props', 'UserController@props');
    Route::get('/', 'UserController@show');
});
