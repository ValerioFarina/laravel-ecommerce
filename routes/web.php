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

Route::get('/', 'HomeController@index')->name('guest.home');

Auth::routes(['register' => false]);

Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('products', 'ProductController');
    Route::get('statistics', 'StatisticsController@index')->name('statistics');
});

Route::prefix('products')->name('guest.products.')->group(function() {
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/{product}', 'ProductController@show')->name('show');
});

Route::get('/searchProduct', 'ProductController@searchProduct')->name('searchProduct');

Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('/', 'CartController@index')->name('index');
    Route::post('/', 'CartController@store')->name('store');
    Route::delete('/', 'CartController@empty')->name('empty');
    Route::delete('/{id}/delete', 'CartController@deleteProduct')->name('product.delete');
});

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');


