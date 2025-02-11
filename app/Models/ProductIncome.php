<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'qty', 'purchase_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
