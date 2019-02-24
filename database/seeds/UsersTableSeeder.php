<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    const CEO_GROUP_ID = 1;
    const MANAGER_GROUP_ID = 2;
    const CLERK_GROUP_ID = 3;
    const SALES_GROUP_ID = 4;
    const REPAIR_GROUP_ID = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $admin = [
            'email' => 'aiproadmin@gmail.com',
            'username' => 'admin',
            'full_name' => 'AiPro Admin',
            'password' => '123456',
            'group_id' => self::CEO_GROUP_ID,
            'branch_id' => '1',
            'created_at' => $date
        ];

        /**
         * Only add admin user in production
         */
        if(App::environment('production')) {
            DB::table('users')->insert($admin);
            return;
        }

        /**
         * Add all user types in production
         */
        DB::table('users')->insert([
            $admin,
            [
                'email' => 'aipromanager@gmail.com',
                'username' => 'manager',
                'full_name' => 'AiPro Manager',
                'password' => '123456',
                'group_id' => self::MANAGER_GROUP_ID,
                'branch_id' => '1',
                'created_at' => $date
            ],
            [
                'email' => 'aiproclerk@gmail.com',
                'username' => 'clerk',
                'full_name' => 'AiPro Clerk',
                'password' => '123456',
                'group_id' => self::CLERK_GROUP_ID,
                'branch_id' => '1',
                'created_at' => $date
            ],
            [
                'email' => 'aiprosales@gmail.com',
                'username' => 'sales',
                'full_name' => 'AiPro Sales',
                'password' => '123456',
                'group_id' => self::SALES_GROUP_ID,
                'branch_id' => '1',
                'created_at' => $date
            ],
            [
                'email' => 'aiprorepair@gmail.com',
                'username' => 'repair',
                'full_name' => 'AiPro Repair',
                'password' => '123456',
                'group_id' => self::REPAIR_GROUP_ID,
                'branch_id' => '1',
                'created_at' => $date
            ],
        ]);
    }
}
