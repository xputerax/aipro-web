<?php

use App\Branch;
use App\Customer;
use App\Order;
use Illuminate\Http\Request;

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
        'inventories' => 'InventoryController',
        'users' => 'UserController',
        'branches' => 'BranchController',
        'products' => 'ProductController',
        'brands' => 'BrandController'
    ]);

    Route::get('customers/{customer}/select', 'CustomerController@select')->name('customers.select');

    Route::get('orders/{order}/generate_receipt', 'OrderController@generateReceipt')->name('orders.generateReceipt');

    /*Route::prefix('api')->group(function () {
        Route::get('customers', function () {
            return datatables()->of(Customer::latest()->get())->toJson();
        });

        Route::get('orders', function () {
            return datatables()->of(Order::latest()->get())->toJson();
        });

        Route::get('orders/{id}/customer', function ($id) {
            $order = Order::find($id);
            $customer = $order->customer()->get();

            return datatables()->of($customer)->toJson();
        });

        Route::get('branches', function () {
            return datatables()->of(Branch::orderBy('id', 'desc')->get())->toJson();
        });
    });*/

    // Route::get('carts', 'CartController@index')->name('carts.index');
    Route::get('carts/{customer}', 'CartController@viewCartByCustomer')->name('carts.viewByCustomer');
    
    Route::post('products/{product}/add_to_cart', 'ProductController@addToCart')->name('products.addToCart');

    Route::get('checkout/{customer}', 'CartController@checkout')->name('checkout');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});

Route::get('/test', function (Request $request) {

    dd(session('test'), session('customer_id'), $request->session()->all());
});