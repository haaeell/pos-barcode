<?php

use App\Http\Controllers\PosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/test-search-performance', [PosController::class, 'testSearchPerformance']);
Route::get('/products', [PosController::class, 'getProducts']);
