<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categories = DB::table('categories')->pluck('id')->toArray();

        $products = [];
        for ($i = 0; $i < 1000; $i++) {
            $products[] = [
                'name' => $faker->word,
                'code' => strtoupper($faker->bothify('???-#####')),
                'sale_price' => $faker->randomFloat(2, 1000, 100000),
                'stock' => $faker->numberBetween(1, 500),
                'unit' => $faker->randomElement(['pcs', 'box', 'kg', 'liter']),
                'category_id' => $faker->randomElement($categories),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
