<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => 'ceo',
                'description' => 'AiPro CEO'
            ],
            [
                'name' => 'manager',
                'description' => 'AiPro Manager'
            ],
            [
                'name' => 'clerk',
                'description' => 'AiPro Clerk'
            ],
            [
                'name' => 'sales',
                'description' => 'AiPro Sales'
            ],
            [
                'name' => 'repair',
                'description' => 'AiPro Repair Person'
            ],
        ]);
    }
}
