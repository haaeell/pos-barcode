<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryExpense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Electronics',
        ]);

        Category::create([
            'name' => 'Furniture',
        ]);

        Category::create([
            'name' => 'Clothing',
        ]);

        Category::create([
            'name' => 'Food & Beverages',
        ]);

        Category::create([
            'name' => 'Sports Equipment',
        ]);

        CategoryExpense::create([
            'name' => 'Operasional',
        ]);

        CategoryExpense::create([
            'name' => 'Gaji Karyawan',
        ]);

        CategoryExpense::create([
            'name' => 'Belanja',
        ]);

    }
}
