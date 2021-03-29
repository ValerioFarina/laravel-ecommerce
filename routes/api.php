<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cart', 'Api\CartController@index');
Route::put('cart/update/quantity', 'Api\CartController@updateQuantity');

Route::get('getStripeKey', function() {
   return response()->json([
       'result' => config('services.stripe.key')
   ]);
});

Route::get('orderByPrice', 'Api\ProductController@orderByPrice');

Route::get('getNumOfItems', 'Api\StatisticsController@getNumOfItems');
Route::get('getRevenues', 'Api\StatisticsController@getRevenues');
