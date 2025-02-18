<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIncome;
use Illuminate\Http\Request;

class ProductIncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductIncome::with('product');
        
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('created_at', $request->date);
        }    

        $data = $query->get();

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

        $product = Product::findOrFail($request->product_id);
        $product->stock += $request->qty;
        $product->save();

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
        $productIncome = ProductIncome::findOrFail($id);
        $oldQty = $productIncome->qty;
        $product = Product::findOrFail($request->product_id);
        $qtyDifference = $request->qty - $oldQty;

        $product->stock += $qtyDifference;
        $product->save();

        $productIncome->update($request->all());

        return redirect()->route('product-incomes.index')->with('success', 'Belanja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        ProductIncome::destroy($id);
        return redirect()->route('product-incomes.index')->with('success', 'Belanja berhasil dihapus.');
    }
}
