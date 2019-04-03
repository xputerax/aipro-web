<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            'name' => 'AiPro Main Branch',
            'address' => 'Taman Semarak Fasa 2, Light Industry, 71800',
            'phone' => '0112345678',
            'email' => 'aiproadmin@gmail.com',
        ]);

        if (App::environment('local') || App::environment('development')) {
            factory(App\Branch::class, 100)->create();
        }
    }
}
