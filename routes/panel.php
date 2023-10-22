<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::post('register', 'UserController@register');
Route::post('mail-reset-password', 'UserController@sendMailResetPassword');
Route::post('reset-password-token', 'UserController@resetPasswordByToken');

Route::middleware('auth:api')->group(function() {
    Route::post('subscribe', 'UserController@subscribe');
    Route::get('store/all', 'UserStoreController@all');
    Route::post('store', 'UserStoreController@store');

    Route::middleware('tenant')
        ->prefix('{tenant}')
        ->group(function() {
            Route::get('home', 'HomeController@get');
            Route::get('address', 'StoreAddressController@get');
            Route::post('address', 'StoreAddressController@updateOrCreate');
            Route::get('schedule', 'StoreScheduleController@get');
            Route::post('schedule', 'StoreScheduleController@createOrUpdate');
            Route::get('configuration', 'StoreConfigurationController@get');
            Route::post('configuration', 'StoreConfigurationController@updateOrCreate');
            Route::post('store/status', 'UserStoreController@setStatus');
            Route::get('category/all', 'CategoryController@all');
            Route::apiResource('category', 'CategoryController');
            Route::apiResource('banner', 'BannerController');
            Route::apiResource('order', 'OrderController');
            Route::apiResource('product', 'ProductController');
            Route::apiResource('product/{product}/photo', 'ProductPhotoController');
            Route::apiResource('product/{product}/prices', 'ProductPriceController');
            Route::apiResource('product/{product}/additionals', 'ProductAdditionalController');
            Route::apiResource('product/{product}/replacements', 'ProductReplacementController');
            Route::get('product/{product}/configuration', 'ProductConfigurationController@get');
            Route::post('product/{product}/configuration', 'ProductConfigurationController@createOrUpdate');
            Route::apiResource('combo', 'ComboController');
            Route::apiResource('combo/{combo}/option', 'ComboOptionController');
            Route::apiResource('card', 'CardController');
            Route::apiResource('waiter', 'WaiterController');
            Route::get('order-manager', 'OrderManagerController@index');
            // Route::apiResource('combo/{combo}/product', 'ComboProductController');
            // Route::apiResource('order/{order}/sub-order', 'SubOrderController');
    });
});


