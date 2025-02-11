<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sale_price', 'stock', 'unit', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productIncomes()
    {
        return $this->hasMany(ProductIncome::class);
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }
}
