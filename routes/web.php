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
Route::post('/home', 'HomeController@store')->name('addCart');
Route::get('/cart', 'HomeController@cart')->name('cart');
Route::delete('/cart', 'HomeController@delete')->name('deleteCart');
Route::post('/order', 'HomeController@order')->name('addOrder');
Route::get('/orders', 'HomeController@orders')->name('orders');
Route::get('/orders/{id}', 'HomeController@showOrder');
Route::get('/notification', 'HomeController@notification');

//Admin group
Route::get('/admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
Route::post('/admin/changeStatus', 'HomeController@adminChangeStatus')->middleware('is_admin');
Route::get('/admin/orders/{id}', 'HomeController@adminShowOrder')->middleware('is_admin');
