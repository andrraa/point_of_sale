<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'category_id' => 1,
                'category_code' => '000',
                'category_name' => 'BARANG DAGANG',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 2,
                'category_code' => '111',
                'category_name' => 'PAKAIAN IMPORT',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 3,
                'category_code' => '112',
                'category_name' => 'MAINAN DAN PERABOT',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 4,
                'category_code' => '113',
                'category_name' => 'TAS IMPORT',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 5,
                'category_code' => '114',
                'category_name' => 'MMB',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 6,
                'category_code' => '115',
                'category_name' => 'MAINAN PREMIUM',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 7,
                'category_code' => '116',
                'category_name' => 'GUDANG PAKAIAN',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 8,
                'category_code' => '117',
                'category_name' => 'PERABOT PREMIUM',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 9,
                'category_code' => '118',
                'category_name' => 'OBRAL',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 10,
                'category_code' => '119',
                'category_name' => 'TAS OBRAL',
                'category_type' => 1,
                'category_price_level' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 11,
                'category_code' => '200',
                'category_name' => 'HARGA UMUM',
                'category_type' => 0,
                'category_price_level' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 12,
                'category_code' => '201',
                'category_name' => 'HARGA GROSIR',
                'category_type' => 0,
                'category_price_level' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 13,
                'category_code' => '202',
                'category_name' => 'HARGA GUDANG',
                'category_type' => 0,
                'category_price_level' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('tbl_categories')->insert($categories);
    }
}
