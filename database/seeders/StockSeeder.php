<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $stocks = [
            [
                'stock_id' => 1,
                'stock_code' => '000',
                'stock_name' => 'BAJU ANAK',
                'stock_category_id' => 1,
                'stock_unit' => 'PCS',
                'stock_purchase_price' => 45000,
                'stock_sale_price_1' => 50000,
                'stock_sale_price_2' => 50000,
                'stock_sale_price_3' => 0,
                'stock_sale_price_4' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'stock_id' => 2,
                'stock_code' => '111',
                'stock_name' => 'BAJU TIDUR ANAK',
                'stock_category_id' => 2,
                'stock_unit' => 'PCS',
                'stock_purchase_price' => 55000,
                'stock_sale_price_1' => 60000,
                'stock_sale_price_2' => 60000,
                'stock_sale_price_3' => 0,
                'stock_sale_price_4' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('tbl_stocks')->insert($stocks);
    }
}
