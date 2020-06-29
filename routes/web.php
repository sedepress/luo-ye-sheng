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
Route::get('/shop', 'ShopController@index');
Route::get('/shop/list', 'ShopController@list')->name('shop.list');
Route::get('/my_props', 'MyPropController@index');
Route::get('/user', 'UserController@show');
