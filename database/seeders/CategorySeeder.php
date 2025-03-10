<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Sembako', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Minuman & Susu', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Makanan Instan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Makanan Ringan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Bumbu Dapur', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Perawatan Diri', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kebersihan Rumah', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Perlengkapan Rumah', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Makanan Kaleng & Beku', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Obat & Kesehatan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
