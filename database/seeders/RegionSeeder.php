<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            [
                'region_id' => 1,
                'region_code' => '0000',
                'region_name' => 'LOKAL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('tbl_regions')->insert($regions);
    }
}
