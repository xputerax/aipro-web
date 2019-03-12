<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Payment;

class PaymentController extends Controller
{
    public function create(Request $request, Order $order)
    {
        $user = Auth::user();
        $branch = $user->branch;
        $customer = $order->customer;

        $data = $request->validate([
            'amount' => [
                'required',
                'numeric'
            ],
            'deposit' => [
                'required',
                'in:0,1'
            ]
        ]);

        $data['branch_id'] = $branch->id;
        $data['customer_id'] = $customer->id;
        $data['order_id'] = $order->id;

        Payment::create($data);

        return redirect()
                ->route('orders.edit', compact('order'));

    }
}
