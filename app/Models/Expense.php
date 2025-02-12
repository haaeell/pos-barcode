<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_expense_id', 'amount',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryExpense::class, 'category_expense_id');
    }
}
