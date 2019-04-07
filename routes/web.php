<?php

Route::get('/', 'Auth\LoginController@showLoginForm')
    ->name('login')
    ->middleware('guest');

Route::post('/', 'Auth\LoginController@login');

Route::middleware('auth')->group(function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('profile', 'ProfileController@editProfile')->name('profile');

    Route::put('profile', 'ProfileController@saveProfile');

    Route::get('customers/selected', 'CustomerController@selected')->name('customers.selected');

    Route::get('customers/deselect', 'CustomerController@deselect')->name('customers.deselect');

    Route::get('customers/deselect/confirm', 'CustomerController@confirmDeselect')->name('customers.deselect.confirm');

    Route::resource('customers', 'CustomerController');

    Route::resource('orders', 'OrderController');

    Route::resource('users', 'UserController');

    Route::resource('branches', 'BranchController');

    Route::get('branches/{branch}/select', 'BranchController@select')->name('branches.select');

    Route::resource('products', 'ProductController');

    Route::resource('brands', 'BrandController');

    Route::get('customers/{customer}/select', 'CustomerController@select')->name('customers.select');

    Route::get('orders/{order}/generate_receipt', 'OrderController@generateReceipt')->name('orders.generateReceipt');

    Route::put('carts/{cart}/modifyQuantity', 'CartController@modifyQuantity')->name('carts.modifyQuantity');

    Route::get('carts/{customer}', 'CartController@viewCartByCustomer')->name('carts.viewByCustomer');

    Route::post('products/{product}/add_to_cart', 'CartController@addToCart')->name('carts.addToCart');

    Route::get('checkout/{customer}', 'CheckoutController@checkout')->name('checkout');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('payments/create/{order}', 'PaymentController@create')->name('payments.create');

    Route::put('carts/{cart}/modifyDescription', 'CartController@modifyDescription')->name('carts.modifyDescription');

    Route::delete('payments/{payment}', 'PaymentController@destroy')->name('payments.destroy');

    Route::prefix('api')->group(function () {

        Route::get('customers', 'CustomerApiController')->name('api.customers.index');

    });

});