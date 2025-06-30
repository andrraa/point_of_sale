<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_id' => 1,
                'full_name' => 'Super Admin',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'user_role_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'full_name' => 'Cashier',
                'username' => 'cashier',
                'password' => Hash::make('cashier'),
                'user_role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('tbl_users')->insert($users);
    }
}
