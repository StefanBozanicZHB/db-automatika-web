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

//Route::get('/', function () {
//    return route('login');
//});

Route::get('/', 'OrderController@index');

Route::resource('clients', 'ClientController');
Route::resource('orders', 'OrderController');
Route::resource('items', 'ItemController');
Route::resource('order_items', 'OrderItemController');
Route::get('api/get_items', 'ItemController@get_items');

Auth::routes();

Route::get('/home', 'OrderController@index')->name('home');
Route::get('/export_pdf/{id}', 'OrderController@export_pdf')->name('export_pdf');