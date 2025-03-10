<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil ID kategori dari tabel categories
        $categories = DB::table('categories')->pluck('id', 'name');

        $products = [
            // Sembako
            ['name' => 'Beras Ramos 5kg', 'sale_price' => 75000, 'unit' => 'karung', 'category' => 'Sembako'],
            ['name' => 'Minyak Goreng Bimoli 1L', 'sale_price' => 18000, 'unit' => 'botol', 'category' => 'Sembako'],
            ['name' => 'Gula Pasir Gulaku 1kg', 'sale_price' => 16500, 'unit' => 'bungkus', 'category' => 'Sembako'],

            // Minuman & Susu
            ['name' => 'Teh Celup Sariwangi 25s', 'sale_price' => 10000, 'unit' => 'kotak', 'category' => 'Minuman & Susu'],
            ['name' => 'Kopi Kapal Api 165g', 'sale_price' => 12500, 'unit' => 'bungkus', 'category' => 'Minuman & Susu'],
            ['name' => 'Susu UHT Ultra Milk 1L', 'sale_price' => 20000, 'unit' => 'kotak', 'category' => 'Minuman & Susu'],

            // Makanan Instan
            ['name' => 'Mie Instan Indomie Ayam Bawang', 'sale_price' => 3500, 'unit' => 'bungkus', 'category' => 'Makanan Instan'],
            ['name' => 'Bubur Instan Sun 120g', 'sale_price' => 8000, 'unit' => 'bungkus', 'category' => 'Makanan Instan'],

            // Makanan Ringan
            ['name' => 'Biskuit Roma Kelapa 300g', 'sale_price' => 14000, 'unit' => 'bungkus', 'category' => 'Makanan Ringan'],
            ['name' => 'Keripik Singkong Kusuka 180g', 'sale_price' => 12000, 'unit' => 'bungkus', 'category' => 'Makanan Ringan'],

            // Bumbu Dapur
            ['name' => 'Kecap Manis ABC 600ml', 'sale_price' => 23000, 'unit' => 'botol', 'category' => 'Bumbu Dapur'],
            ['name' => 'Saus Sambal Indofood 275ml', 'sale_price' => 10500, 'unit' => 'botol', 'category' => 'Bumbu Dapur'],

            // Perawatan Diri
            ['name' => 'Sabun Lifebuoy 85g', 'sale_price' => 4500, 'unit' => 'batang', 'category' => 'Perawatan Diri'],
            ['name' => 'Sampo Sunsilk 170ml', 'sale_price' => 25000, 'unit' => 'botol', 'category' => 'Perawatan Diri'],
            ['name' => 'Pasta Gigi Pepsodent 190g', 'sale_price' => 15000, 'unit' => 'tube', 'category' => 'Perawatan Diri'],

            // Kebersihan Rumah
            ['name' => 'Detergen Rinso 800g', 'sale_price' => 20000, 'unit' => 'bungkus', 'category' => 'Kebersihan Rumah'],
            ['name' => 'Pembersih Lantai Wipol 750ml', 'sale_price' => 25000, 'unit' => 'botol', 'category' => 'Kebersihan Rumah'],

            // Perlengkapan Rumah
            ['name' => 'Lampu LED Philips 10W', 'sale_price' => 30000, 'unit' => 'pcs', 'category' => 'Perlengkapan Rumah'],
            ['name' => 'Sapu Lidi', 'sale_price' => 15000, 'unit' => 'pcs', 'category' => 'Perlengkapan Rumah'],

            // Makanan Kaleng & Beku
            ['name' => 'Sarden ABC 425g', 'sale_price' => 25000, 'unit' => 'kaleng', 'category' => 'Makanan Kaleng & Beku'],
            ['name' => 'Nugget So Good 500g', 'sale_price' => 40000, 'unit' => 'bungkus', 'category' => 'Makanan Kaleng & Beku'],

            // Obat & Kesehatan
            ['name' => 'Paracetamol 500mg 10 tablet', 'sale_price' => 7000, 'unit' => 'strip', 'category' => 'Obat & Kesehatan'],
            ['name' => 'Betadine Antiseptik 30ml', 'sale_price' => 20000, 'unit' => 'botol', 'category' => 'Obat & Kesehatan'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'code' => strtoupper($faker->bothify('???-#####')),
                'sale_price' => $product['sale_price'],
                'unit' => $product['unit'],
                'category_id' => $categories[$product['category']],
                'stock' => $faker->numberBetween(1, 200),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
