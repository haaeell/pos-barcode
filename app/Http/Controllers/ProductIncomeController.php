<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIncome;
use Illuminate\Http\Request;

class ProductIncomeController extends Controller
{
    public function index()
    {
        $data = ProductIncome::with('product')->get();
        return view('product-incomes.index', compact('data'));
    }

    public function create()
    {
        $products = Product::all();
        return view('product-incomes.create', compact('products'));
    }

    public function store(Request $request)
    {
        ProductIncome::create($request->all());
        return redirect()->route('product-incomes.index')->with('success', 'Belanja berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = ProductIncome::findOrFail($id);
        return view('product-incomes.show', compact('data'));
    }

    public function edit($id)
    {
        $data = ProductIncome::findOrFail($id);
        $products = Product::all();
        return view('product-incomes.edit', compact('data', 'products'));
    }

    public function update(Request $request, $id)
    {
        $data = ProductIncome::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('product-incomes.index')->with('success', 'Belanja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        ProductIncome::destroy($id);
        return redirect()->route('product-incomes.index')->with('success', 'Belanja berhasil dihapus.');
    }
}
