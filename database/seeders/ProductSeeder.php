<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $furniture = Category::where('name', 'Furniture')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $food = Category::where('name', 'Food & Beverages')->first();
        $sports = Category::where('name', 'Sports Equipment')->first();

        Product::create([
            'name' => 'Smartphone',
            'code' => '12345678',
            'sale_price' => 1000.00,
            'stock' => 50,
            'unit' => 'Piece',
            'category_id' => $electronics->id,
        ]);

        Product::create([
            'name' => 'Laptop',
            'code' => '12345679',
            'sale_price' => 1500.00,
            'stock' => 30,
            'unit' => 'Piece',
            'category_id' => $electronics->id,
        ]);

        Product::create([
            'name' => 'Sofa',
            'code' => '12345670',
            'sale_price' => 500.00,
            'stock' => 20,
            'unit' => 'Piece',
            'category_id' => $furniture->id,
        ]);

        Product::create([
            'name' => 'T-Shirt',
            'code' => '12345677',
            'sale_price' => 20.00,
            'stock' => 100,
            'unit' => 'Piece',
            'category_id' => $clothing->id,
        ]);

        Product::create([
            'name' => 'Pizza',
            'code' => '12345676',
            'sale_price' => 15.00,
            'stock' => 200,
            'unit' => 'Piece',
            'category_id' => $food->id,
        ]);

        Product::create([
            'name' => 'Tennis Racket',
            'code' => '12345675',
            'sale_price' => 80.00,
            'stock' => 10,
            'unit' => 'Piece',
            'category_id' => $sports->id,
        ]);
    }
}
