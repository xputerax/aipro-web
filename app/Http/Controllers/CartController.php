<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the customer cart page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Show the customer cart page.
     *
     * @param \App\Customer $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCartByCustomer(Customer $customer)
    {
        return view('cart.view-by-customer', compact('customer'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $user = Auth::user();
        $customer = session('customer');

        $data = $request->validate([
            'price' => [
                'required',
                'numeric',
            ],
            'quantity' => [
                'required',
                'integer',
                'lte:'.$product->stock,
            ],
        ]);

        $cart = new Cart();
        $cart->branch_id = $user->branch_id;
        $cart->customer_id = $customer->id;
        $cart->product_id = $product->id;
        $cart->price = $data['price'];
        $cart->quantity = $data['quantity'];

        if ('product' === $product->type) {
            $product->stock -= $data['quantity'];
        }

        if ($cart->save() && $product->save()) {
            $request->session()->flash('message', 'Item added to cart');
        } else {
            $request->session()->flash('message', 'Failed to add item to cart');
        }

        return redirect()
            ->route('products.index')
        ;
    }

    public function modifyQuantity(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'lte:'.$cart->product->stock,
            ],
        ]);

        if ('0' === $data['quantity']) {
            $this->removeFromCart($request, $cart);
        } else {
            $quantity_difference = $cart->quantity - $data['quantity'];

            $product = $cart->product;

            if ('product' === $product->type) {
                $product->stock += $quantity_difference;
                $product->save();
            }

            $cart->quantity = $data['quantity'];
            $cart->save();
        }

        return redirect()
            ->route('carts.viewByCustomer', [
                'customer' => $cart->customer,
            ])
        ;
    }

    public function removeFromCart(Request $request, Cart $cart)
    {
        $product = $cart->product;

        if ('product' === $product->type) {
            $product->stock += $cart->quantity;
        }

        if ($product->save() && $cart->delete()) {
            $request->session()->flash('message', 'Item removed from cart');
        } else {
            $request->session()->flash('message', 'Failed to remove item from cart');
        }

        return redirect()
            ->route('products.index')
        ;
    }

    public function modifyDescription(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'description' => [
                'present',
            ],
        ]);

        $cart->update($data);

        return redirect()
            ->route('carts.viewByCustomer', ['customer' => session('customer')])
        ;
    }
}
