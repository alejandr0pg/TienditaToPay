<?php

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
    $name = 'Mi tiendita online';

    return view('welcome', compact('name'));
});

Route::get('/orders', 'OrdersController@getAllOrders');
Route::get('/orders/{orderUID}', 'OrdersController@getOrderByUid');

Route::post('/orders', 'OrdersController@generateOrder')->name('order-generate');
Route::post('/order/{orderUID}', 'OrdersController@payOrder');

