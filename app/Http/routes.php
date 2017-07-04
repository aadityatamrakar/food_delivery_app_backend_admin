<?php

Route::get('/', "LoginController@index")->name("first");
Route::get('/login', "LoginController@getLogin")->name('login');
Route::post('/login', "LoginController@postLogin");

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    Route::get('/city', 'CityController@index')->name('city');

    Route::post('/city/add', 'CityController@addCity')->name('addCity');
    Route::post('/city/remove', 'CityController@removeCity')->name('removeCity');

    Route::post('/area/add', 'CityController@addArea')->name('addArea');
    Route::post('/area/get', 'CityController@viewArea')->name('viewArea');
    Route::post('/area/edit', 'CityController@editArea')->name('editArea');
    Route::post('/area/del', 'CityController@delArea')->name('delArea');

    Route::get('/restaurants', 'RestaurantsController@index')->name('restaurants');
    Route::get('/restaurants/view/{id}', 'RestaurantsController@viewRestaurants')->name('restaurants.view');
    Route::get('/restaurants/edit/{id}', 'RestaurantsController@getEdit')->name('restaurants.edit');
    Route::post('/restaurants/edit/{id}', 'RestaurantsController@postEdit');
    Route::get('/restaurants/add', 'RestaurantsController@getAdd')->name('restaurants.add');
    Route::post('/restaurants/add', 'RestaurantsController@postAdd');
    Route::get('/restaurants/time/{id}', 'RestaurantsController@getTime')->name('restaurants.time');
    Route::post('/restaurants/time/{id}/{time}', 'RestaurantsController@postTime');
    Route::post('/restaurants/area/{id}', 'RestaurantsController@postArea')->name('restaurants.area');
    Route::get('/restaurants/delete/{id}', 'RestaurantsController@getDelete')->name('restaurants.delete');
    Route::post('/restaurants/delete/{id}', 'RestaurantsController@postDelete');
    Route::get('/restaurants/menu/{id}', 'RestaurantsController@getMenu')->name('restaurants.menu');
    Route::get('/restaurants/menu/{id}/category/add', 'RestaurantsController@addCategory')->name('restaurants.addCategory');
    Route::post('/restaurants/menu/{id}/category/add', 'RestaurantsController@postAddCategory');
    Route::get('/restaurants/menu/{id}/category/{category_id}/edit', 'RestaurantsController@editCategory')->name('restaurants.editCategory');
    Route::post('/restaurants/menu/{id}/category/{category_id}/edit', 'RestaurantsController@postEditCategory');
    Route::post('/restaurants/menu/category/del', 'RestaurantsController@delCategory')->name('delCategory');
    Route::get('/category/{id}', 'RestaurantsController@getProducts')->name('restaurants.category');
    Route::get('/category/{id}/product/add', 'RestaurantsController@addProduct')->name('restaurants.addProduct');
    Route::post('/category/{id}/product/add', 'RestaurantsController@postAddProduct');
    Route::get('/category/{id}/product/{prod_id}/edit', 'RestaurantsController@editProduct')->name('restaurants.editProduct');
    Route::post('/category/{id}/product/{prod_id}/edit', 'RestaurantsController@postEditProduct');
    Route::post('/category/product/del', 'RestaurantsController@delProduct')->name('delProduct');
    Route::get('/orders', 'OrdersController@index')->name('orders');
    Route::get('/orders/view/{id}', 'OrdersController@view_cart')->name('orders.view');
    Route::post('/orders/status_update/{id}', 'OrdersController@change_status')->name('orders.changeStatus');
    Route::post('/orders/resend_details/{id}', 'OrdersController@resend_details')->name('orders.resend_details');
    Route::get('/orders/restaurant/{id}', 'OrdersController@indexRestaurant')->name('restaurants.orders');
    Route::get('/orders/customer/{id}', 'OrdersController@indexCustomer')->name('customers.orders');
    Route::get('/customers', 'HomeController@customers_index')->name('customers');
    Route::get('/customers/{id}', 'HomeController@customers_view')->name('customers.view');
    Route::post('/customers/del', 'HomeController@delCustomer')->name('removeCustomer');
    Route::get('/referral', 'HomeController@referral')->name('referral');
    Route::post('/referral/del', 'HomeController@referral_del')->name('removeReferral');

    Route::get('/coupon', 'HomeController@coupon')->name('coupon');
    Route::get('/coupon/add', 'HomeController@coupon_add')->name('coupon.add');
    Route::post('/coupon/add', 'HomeController@post_coupon_add');
    Route::get('/coupon/edit/{id}', 'HomeController@coupon_edit')->name('coupon.edit');
    Route::post('/coupon/edit/{id}', 'HomeController@post_coupon_edit');
    Route::post('/coupon/del', 'HomeController@delCoupon')->name('coupon.remove');

    Route::get('/payment', 'PaymentController@index')->name('payment.index');
    Route::post('/payment/request', 'PaymentController@payment_request')->name('payment.request');
    Route::post('/payment/remove', 'PaymentController@payment_remove')->name('payment.remove');
    Route::post('/payment/save', 'PaymentController@payment_save')->name('payment.save');

    Route::get('/wallet/customer/{customer_id}', 'WalletController@index')->name('customers.wallet');
    Route::get('/wallet/all', 'WalletController@all_transaction')->name('wallet.all_transactions');
    Route::get('/wallet/manage', 'WalletController@manage')->name('wallet.index');
    Route::get('/wallet/summary', 'WalletController@summary')->name('wallet.summary');
    Route::post('/wallet/details', 'WalletController@details')->name('wallet.details');
    Route::post('/wallet/update', 'WalletController@update')->name('wallet.update');


    Route::get('/banner/index', 'BannerController@index')->name('banner.index');
    Route::get('/banner/delete/{id}', 'BannerController@delete')->name('banner.delete');
    Route::post('/banner/upload', 'BannerController@upload')->name('banner.upload');

});

Route::post('/request_otp', "LoginController@request_otp")->name("request_otp");
Route::get('/logout', "LoginController@logout")->name("logout");

Route::post('/api/check_bal',['middleware'=>'api', 'uses'=>"HomeController@check_bal"]);
Route::post('/api/payout',['middleware'=>'api', 'uses'=>"HomeController@request_payment"]);

Route::get('/test', "HomeController@test")->name("test");

//Route::group(['middleware' => 'api'], function () {
//
//});
