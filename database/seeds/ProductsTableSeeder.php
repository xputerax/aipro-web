<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('production')) return;

        $number_of_brands = \App\Brand::count();
        $number_of_products = 1000;

        for ($product_id = 1; $product_id <= $number_of_products; $product_id++) {
            $branch_id = (function () {
                $branches_id = [1,2,3];
                $key = mt_rand(0, count($branches_id) - 1);

                return $branches_id[$key];
            })();
            $brand_id = mt_rand(1, $number_of_brands);
            $name = $description = (function () use ($branch_id, $brand_id, $product_id) {
                $names = ["Laptop #%d%d%d", "Smartphone #%d%d%d", "Tablet #%d%d%d", "PC #%d%d%d"];
                $key = array_rand($names, 1);

                return sprintf($names[$key], $branch_id, $brand_id, $product_id);
            })();
            $min_price = mt_rand(100, 1000);
            $max_price = mt_rand($min_price+1, 1500);
            $stock = mt_rand(0, 30);
            $type = (function () {
                $types = ["product", "service"];
                $key = array_rand($types, 1);

                return $types[$key];
            })();
            $created_at = now('Asia/Kuala_Lumpur');

            DB::table('products')
                ->insert(
                    compact(
                        'branch_id', 'brand_id', 'name',
                        'description', 'min_price', 'max_price',
                        'stock', 'type', 'created_at'
                    )
                );
        }
    }
}
