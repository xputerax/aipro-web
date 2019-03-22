<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    const ORDER_STATUS_PENDING = 'pending';
    const ORDER_STATUS_RESOLVED = 'resolved';
    const ORDER_STATUS_DELIVERED = 'delivered';

    public function checkout(Request $request, Customer $customer)
    {
        /**
         * Get customer cart items.
         */
        $cartItems = $customer->carts;

        /**
         * Create new order
         * pls check.
         */
        $order = new Order();
        $order->branch_id = $customer->branch_id;
        $order->customer_id = $customer->id;
        $order->checkout_user_id = Auth::user()->id;
        $order->status = self::ORDER_STATUS_PENDING;
        $order->deposit = '0.00';
        $order->checkout_at = Carbon::now();
        $order->save();

        foreach ($cartItems as $cartItem) {
            // Copy each cart item into order_products
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cartItem->product_id;
            $orderProduct->price = $cartItem->price;
            $orderProduct->quantity = $cartItem->quantity;
            $orderProduct->description = $cartItem->description;
            $orderProduct->save();

            // Delete the item from the cart
            $cartItem->delete();
        }

        return redirect()
            ->route('orders.index')
        ;
    }
}
