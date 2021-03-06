<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupsTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(ProductModelTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderPaymentsTableSeeder::class);
    }
}
