<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'customer_id' => 1,
                'customer_category_id' => 11,
                'customer_name' => 'Pelanggan Umum',
                'customer_address' => 'Indonesia',
                'customer_region_id' => 1,
                'customer_phone_number' => null,
                'customer_npwp_number' => null,
                'customer_credit_limit' => 0,
                'customer_status' => 1
            ]
        ];

        DB::table('tbl_customers')->insert($customers);
    }
}
