<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('production')) return;

        for ($branch_id = 1; $branch_id <= 3; $branch_id++) {
            $customers_count = min(
                5,
                mt_rand(5, \App\Customer::where('branch_id', $branch_id)->count())
            );
            $customers = \App\Customer::orderByRaw('RAND()')
                ->where('branch_id', $branch_id)
                ->limit($customers_count)
                ->get();

            foreach ($customers as $customer) {
                $customer_id = $customer->id;
                $checkout_user_id = $customer->user_id;

                for ($order_count = 1; $order_count <= mt_rand(1, 3); $order_count++) {
                    $resolve_user_id = null;
                    $delivery_user_id = null;
                    $checkout_at = $created_at = now();
                    $resolved_at = null;
                    $delivered_at = null;
                    $status = 'pending';
                    $rand = mt_rand(1, 10);

                    if ($rand > 7) {
                        $status = 'delivered';
                        $delivery_user_id = $resolve_user_id = $customer->user_id;
                        $delivered_at = $resolved_at = $checkout_at;
                    } elseif ($rand > 4) {
                        $status = 'resolved';
                        $resolve_user_id = $customer->user_id;
                        $resolved_at = $checkout_at;
                    }

                    $order_id = DB::table('orders')->insertGetId(
                        compact(
                            'branch_id', 'customer_id', 'checkout_user_id',
                            'resolve_user_id', 'delivery_user_id', 'status',
                            'checkout_at', 'resolved_at', 'delivered_at',
                            'created_at'
                        )
                    );

                    for ($order_product_count = 1; $order_product_count <= mt_rand(1, 5); $order_product_count++) {
                        $product = \App\Product::orderbyRaw('RAND()')
                            ->where('branch_id', $branch_id)
                            ->first();

                        DB::table('order_products')->insert([
                            'order_id' => $order_id,
                            'product_id' => $product->id,
                            'price' => mt_rand($product->min_price, $product->max_price),
                            'quantity' => mt_rand(1, 5),
                            'description' => null,
                            'created_at' => now()
                        ]);
                    }
                }
            }
        }

    }
}
