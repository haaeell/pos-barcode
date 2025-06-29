<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ProductTemplateExport implements FromCollection
{
    public function collection()
    {
        return new Collection([
            ['name', 'code', 'sale_price', 'stock', 'unit', 'category', 'discount'],
            ['Contoh Produk', 'PRD001', 15000, 100, 'pcs', 'Minuman', 10],
        ]);
    }
}
