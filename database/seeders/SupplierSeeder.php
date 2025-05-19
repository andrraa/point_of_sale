<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'supplier_id' => 1,
                'supplier_code' => '000',
                'supplier_name' => 'ANDRA',
                'supplier_address' => 'LAMPUNG',
                'supplier_region_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('tbl_suppliers')->insert($suppliers);
    }
}
