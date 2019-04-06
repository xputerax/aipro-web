<?php

use Illuminate\Database\Seeder;

class OrderPaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Order::all() as $order) {
            $order_id = $order->id;
            $branch_id = $order->branch_id;
            $customer_id = $order->customer_id;

            foreach ($order->order_products as $item) {
                $rand = mt_rand(1, 2);

                if ($rand === 2) {
                    $item_qty = $item->quantity;
                    $item_price = $item->price;
                    $amount = $item_price * $item_qty;

                    $payment = new \App\Payment(compact('branch_id', 'customer_id', 'order_id', 'amount'));
                    $payment->save();
                }
            }
        }
    }
}
