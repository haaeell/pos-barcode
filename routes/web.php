<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductIncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionProductController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product-incomes', ProductIncomeController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('transaction-products', TransactionProductController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
