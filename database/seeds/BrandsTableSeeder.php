<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('production')) return;

        $number_of_branch = 3;

        for ($i = 1; $i <= $number_of_branch; $i++) {
            DB::table('brands')->insert([
                [
                    'branch_id' => $i,
                    'name' => 'Apple',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Samsung',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Huawei',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Oppo',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'OnePlus',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Xiaomi',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Google',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Sony',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Nokia',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'LG',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Honor',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Motorola',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'ZTE',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'BlackBerry',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Acer',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Realme',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Lenovo',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'Vivo',
                    'created_at' => now()
                ],
                [
                    'branch_id' => $i,
                    'name' => 'HTC',
                    'created_at' => now()
                ],
            ]);
        }
    }
}
