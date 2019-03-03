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

    Route::resources([
        'customers' => 'CustomerController',
        'orders' => 'OrderController',
        'users' => 'UserController',
        'branches' => 'BranchController',
        'products' => 'ProductController',
        'brands' => 'BrandController'
    ]);

    Route::get('customers/{customer}/select', 'CustomerController@select')->name('customers.select');

    Route::get('orders/{order}/generate_receipt', 'OrderController@generateReceipt')->name('orders.generateReceipt');

    Route::put('carts/{cart}/modify', 'CartController@modifyCart')->name('carts.modify');

    Route::get('carts/{customer}', 'CartController@viewCartByCustomer')->name('carts.viewByCustomer');
    
    Route::post('products/{product}/add_to_cart', 'CartController@addToCart')->name('carts.addToCart');

    Route::get('checkout/{customer}', 'CheckoutController@checkout')->name('checkout');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});