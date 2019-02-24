<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(App::environment('local')) {
            factory(\App\Customer::class, 1000)->create();
        }
    }
}
