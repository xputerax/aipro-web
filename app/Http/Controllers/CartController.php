<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    const ORDER_STATUS_PENDING = 'pending';
    const ORDER_STATUS_RESOLVED = 'resolved';
    const ORDER_STATUS_DELIVERED = 'delivered';

    public function index()
    {
        return view('cart.index');
    }

    public function viewCartByCustomer(Customer $customer)
    {
        return view('cart.view-by-customer', compact('customer'));
    }

    public function checkout(Customer $customer)
    {
        /**
         * Get customer cart items.
         */
        $cartItems = $customer->carts;

        $date = Carbon::now();

        /**
         * Create new order
         * pls check.
         */
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->checkout_user_id = $order->resolve_user_id = $order->delivery_user_id = Auth::user()->id;
        // $order->resolve_user_id = null;
        // $order->delivery_user_id = null;
        $order->status = self::ORDER_STATUS_PENDING;
        $order->deposit = '0.00';
        $order->checkout_at = $order->resolved_at = $order->delivered_at = $date;
        $order->save();

        // Copy each cart item into order_products
        foreach ($cartItems as $cartItem) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cartItem->product_id;
            $orderProduct->price = $cartItem->price;
            $orderProduct->quantity = $cartItem->quantity;
            $orderProduct->save();

            // Delete the item from the cart
            $cartItem->delete();
        }

        return response('done');
    }
}
