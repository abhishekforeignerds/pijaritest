<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PhonepeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {

    //Auth Route
    Route::post('send-otp', 'AuthApiController@sendOtp');
    Route::post('verify-otp', 'AuthApiController@verifyOtp');

    // Delivery Boy Auth
    Route::post('login', 'DeliveryBoyApiController@login');

    Route::group(["middleware" => ["auth:sanctum"]], function(){

        // Authenticated Routes
        Route::get('profile', 'ProfileApiController@profile');
        Route::post('profile-update', 'ProfileApiController@updateProfile');
        Route::post('add-favourite', 'FavouriteApiController@addFavourite');
        Route::get('favourite', 'FavouriteApiController@getFavourite');
        Route::get('delete-favourite/{id}', 'FavouriteApiController@delete');
        Route::post('logout', 'AuthApiController@logout');
        Route::post('add-to-cart', 'AddToCartApiController@addCart');
        Route::get('cart', 'AddToCartApiController@getCart');
        Route::get('delete-cart/{id}', 'AddToCartApiController@cartDelete');
        Route::post('add-address', 'AddressApiController@addAddress');
        Route::get('address', 'AddressApiController@getAddress');
        Route::get('edit-address/{id}', 'AddressApiController@editAddress');
        Route::post('update-address', 'AddressApiController@updateAddress');
        Route::get('delete-address/{id}', 'AddressApiController@deleteAddress');
        Route::post('order', 'OrderApiController@order');
        Route::get('purchase-history', 'PurchaseHistoryApiController@index');
        Route::get('user-today-order', 'PurchaseHistoryApiController@todayOrder');
        Route::get('user-order-detail', 'UserOrderApiController@orderDetail');
        Route::post('user-order-cancel', 'UserOrderApiController@orderCancel');

        // Delivery Boy Routes
        Route::get('today-order', 'DeliveryBoyApiController@todayOrder');
        Route::post('order-status', 'DeliveryBoyApiController@orderStatus');
        Route::get('order-delivered-list', 'DeliveryBoyApiController@orderDelivered');
        Route::get('delivery-boy-profile', 'DeliveryBoyApiController@deliveryBoyProfile');
        Route::post('delivery-boy-edit', 'DeliveryBoyApiController@deliveryBoyProfileUpdate');
        Route::post('delivery-boy-change-password', 'DeliveryBoyApiController@changePassword');
        Route::post('forgot-password', 'DeliveryBoyApiController@forgotPassword');
        Route::post('reset-password', 'DeliveryBoyApiController@resetPassword');

        Route::get('wallet/balance', 'UserOrderApiController@balance');


    });

        Route::get('home', 'HomeApiController@index');
        Route::get('search', 'HomeApiController@search');
        Route::get('product-detail/{id}', 'ProductDetailApiController@productDetail');
        Route::get('getDeliveryPincode', 'HomeApiController@getDeliveryPincode');
        Route::get('area_pincode_list', 'HomeApiController@area_pincode_list');


        Route::get('phonepe/payment/pay', 'PhonepeController@pay');
        Route::any('/phonepe/redirecturl', 'PhonepeController@phonepe_redirecturl')->name('api.phonepe.redirecturl');
        Route::any('/phonepe/callbackUrl', 'PhonepeController@phonepe_callbackUrl')->name('api.phonepe.callbackUrl');


});

