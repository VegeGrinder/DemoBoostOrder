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

Route::get('/home', 'HomeController@index')->name('home');  //User home
Route::post('/home', 'HomeController@store')->name('addCart');  //User home -> add product to cart (AJAX)
Route::get('/cart', 'HomeController@cart')->name('cart');   //User cart displaying products taken from above
Route::delete('/cart', 'HomeController@delete')->name('deleteCart');    //User cart -> delete product (AJAX)
Route::post('/order', 'HomeController@order')->name('addOrder');    //User cart -> check out -> redirect to below
Route::get('/orders', 'HomeController@orders')->name('orders'); //User page displaying orders made
Route::get('/orders/{id}', 'HomeController@showOrder'); //User page show one order's details
Route::get('/notification', 'HomeController@notification'); //User auto notification every 8 seconds (AJAX)

//Admin group
Route::get('/admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');  //Admin home display ALL orders
Route::post('/admin/changeStatus', 'HomeController@adminChangeStatus')->middleware('is_admin'); //Admin change status at home or detailed view (AJAX)
Route::get('/admin/orders/{id}', 'HomeController@adminShowOrder')->middleware('is_admin');  //Admin show detailed view of an order
