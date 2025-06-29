<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $categoryMap = Category::pluck('id', 'name')->toArray();
        $existingCodes = Product::pluck('code')->toArray();
        $newCodes = [];
        $newProducts = [];

        foreach ($rows as $row) {
            $code = $row['code'];
            $categoryName = $row['category'];

            if (in_array($code, $existingCodes) || in_array($code, $newCodes)) {
                continue;
            }

            if (!isset($categoryMap[$categoryName])) {
                $category = Category::create(['name' => $categoryName]);
                $categoryMap[$categoryName] = $category->id;
            }

            $newProducts[] = [
                'name'        => $row['name'],
                'code'        => $code,
                'sale_price'  => $row['sale_price'],
                'stock'       => $row['stock'],
                'unit'        => $row['unit'],
                'discount'    => $row['discount'],
                'category_id' => $categoryMap[$categoryName],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            $newCodes[] = $code;
        }

        Product::insert($newProducts);
    }
}
