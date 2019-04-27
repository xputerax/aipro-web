<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProductModelTableSeeder extends Seeder
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
            $brands = \App\Brand::select('id')->where('branch_id', $branch_id)->limit(5)->get()->flatten();

            foreach ($brands as $brand) {
                $brand_id = $brand->id;

                for ($i=0; $i<=3; ++$i) {
                    $name = $description = sprintf("Model %d %d %d", $branch_id, $brand_id, $i);

                    \App\ProductModel::create(compact('branch_id', 'brand_id', 'name', 'description'));
                }
            }
        }
    }
}
