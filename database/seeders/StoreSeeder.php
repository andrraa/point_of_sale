<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $store = [
            'store_id' => 1,
            'store_name' => 'Dummy Toko',
            'store_address' => 'Dummy Alamat Toko',
            'store_phone_number' => '081267483920',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('tbl_store')->insert($store);
    }
}
