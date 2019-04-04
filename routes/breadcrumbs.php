<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

/**
 * Selected Branch
 */
Breadcrumbs::for('selected-branch', function ($trail) {
    $branch = App\Branch::find(session()->get('selected_branch_id'));

    $trail->push($branch->name, route('branches.index'));
});

/**
 * Dashboard
 */
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('Dashboard', route('dashboard'));
});

/**
 * Customer
 */
Breadcrumbs::for('customer-index', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('Customer', route('customers.index'));
});

Breadcrumbs::for('customer-create', function ($trail) {
    $trail->parent('customer-index');
    $trail->push('Add', route('customers.create'));
});

Breadcrumbs::for('customer-view-selected', function ($trail) {
    $trail->parent('customer-index');
    $trail->push('Selected Customer', route('customers.selected'));
});

Breadcrumbs::for('customer-deselect', function ($trail) {
    $trail->parent('customer-index');
    $trail->push('Deselect Customer', route('customers.deselect'));
});

Breadcrumbs::for('customer-show', function ($trail, $customer) {
    $trail->parent('customer-index');
    $trail->push($customer->full_name, route('customers.show', $customer));
});

Breadcrumbs::for('customer-edit', function ($trail, $customer) {
    $trail->parent('customer-show', $customer);
    $trail->push('Edit', route('customers.edit', $customer));
});

/**
 * Order
 */
Breadcrumbs::for('order-index', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('Order', route('orders.index'));
});

Breadcrumbs::for('order-pending', function ($trail) {
    $trail->parent('order-index');
    $trail->push('Pending', route('orders.index', ['status' => 'pending']));
});

Breadcrumbs::for('order-resolved', function ($trail) {
    $trail->parent('order-index');
    $trail->push('Resolved', route('orders.index', ['status' => 'resolved']));
});

Breadcrumbs::for('order-delivered', function ($trail) {
    $trail->parent('order-index');
    $trail->push('Delivered', route('orders.index', ['status' => 'delivered']));
});

Breadcrumbs::for('order-edit', function ($trail, $order) {
    $trail->parent('order-index');
    $trail->push('Edit Order #'.$order->id, route('orders.edit', compact('order')));
});

/**
 * Branch
 */
Breadcrumbs::for('branch-index', function ($trail) {
    $trail->push('Branch', route('branches.index'));
});

Breadcrumbs::for('branch-create', function ($trail) {
    $trail->parent('branch-index');
    $trail->push('All', route('branches.create'));
});

Breadcrumbs::for('branch-show', function ($trail, $branch) {
    $trail->parent('branch-index');
    $trail->push($branch->name, route('branches.show', compact('branch')));
});

Breadcrumbs::for('branch-edit', function ($trail, $branch) {
    $trail->parent('branch-show', $branch);
    $trail->push('Edit', route('branches.edit', compact('branch')));
});

/**
 * User
 */
Breadcrumbs::for('user-index', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('User', route('users.index'));
});

Breadcrumbs::for('user-create', function ($trail) {
    $trail->parent('user-index');
    $trail->push('Add', route('users.create'));
});

Breadcrumbs::for('user-edit', function ($trail, $user) {
    $trail->parent('user-index');
    $trail->push($user->full_name, route('users.edit', $user));
});

Breadcrumbs::for('user-profile', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('My Profile', route('profile'));
});

/**
 * Brand
 */
Breadcrumbs::for('brand-index', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('Brand', route('brands.index'));
});

Breadcrumbs::for('brand-create', function ($trail) {
    $trail->parent('brand-index');
    $trail->push('Add', route('brands.create'));
});

Breadcrumbs::for('brand-show', function ($trail, $brand) {
    $trail->parent('brand-index');
    $trail->push($brand->name, route('brands.show', $brand));
});

/**
 * Product
 */
Breadcrumbs::for('product-index', function ($trail) {
    $trail->parent('selected-branch');
    $trail->push('Product', route('products.index'));
});

Breadcrumbs::for('product-create', function ($trail) {
    $trail->parent('product-index');
    $trail->push('Add', route('products.create'));
});

Breadcrumbs::for('product-edit', function ($trail, $product) {
    $trail->parent('product-index');
    $trail->push($product->name, route('products.edit', $product));
});

/**
 * Cart
 */
Breadcrumbs::for('cart', function ($trail, $customer) {
    $trail->parent('customer-show', $customer);
    $trail->push('Cart', route('carts.viewByCustomer', $customer));
});