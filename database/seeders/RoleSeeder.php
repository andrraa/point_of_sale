<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'role_id' => 1,
                'role_name' => 'Admin'
            ],
            [
                'role_id' => 2,
                'role_name' => 'Cashier'
            ]
        ];

        DB::table('tbl_roles')->insert($roles);
    }
}
