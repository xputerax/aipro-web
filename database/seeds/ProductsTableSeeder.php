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

        foreach ([1, 2, 3] as $branch_id) {
            // each branch nak 50 products
            for ($i=1; $i<=50; $i++) {
                // get random model with current brand id & branch id
                $model = \App\ProductModel::where(compact('branch_id'))->orderByRaw('RAND()')->limit(1)->first();

                $name = $description = (function () use ($model) {
                    $category = (function () {
                        $list = ['Laptop', 'Phone', 'Tablet'];
                        $key = mt_rand(0, count($list)-1);

                        return $list[$key];
                    })();

                    return sprintf("%s #%d%d%d", $category, $model->branch_id, $model->brand_id, $model->id);
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

                \App\Product::create([
                    'branch_id' => $branch_id,
                    'brand_id' => $model->brand_id,
                    'model_id' => $model->id,
                    'name' => $name,
                    'description' => $description,
                    'min_price' => $min_price,
                    'max_price' => $max_price,
                    'stock' => $stock,
                    'type' => $type,
                    'created_at' => $created_at
                ]);
            }
        }
    }
}
