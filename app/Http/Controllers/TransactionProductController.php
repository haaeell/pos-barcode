<?php

namespace App\Http\Controllers;

use App\Models\TransactionProduct;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionProductController extends Controller
{
    public function index()
    {
        $transactionProducts = TransactionProduct::with(['transaction', 'product'])->get();
        return view('transaction-products.index', compact('transactionProducts'));
    }

    public function create()
    {
        $transactions = Transaction::all();
        $products = Product::all();
        return view('transaction-products.create', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        TransactionProduct::create($request->all());
        return redirect()->route('transaction-products.index');
    }

    public function show($id)
    {
        $transactionProduct = TransactionProduct::findOrFail($id);
        return view('transaction-products.show', compact('transactionProduct'));
    }

    public function edit($id)
    {
        $transactionProduct = TransactionProduct::findOrFail($id);
        $transactions = Transaction::all();
        $products = Product::all();
        return view('transaction-products.edit', compact('transactionProduct', 'transactions', 'products'));
    }

    public function update(Request $request, $id)
    {
        $transactionProduct = TransactionProduct::findOrFail($id);
        $transactionProduct->update($request->all());
        return redirect()->route('transaction-products.index');
    }

    public function destroy($id)
    {
        TransactionProduct::destroy($id);
        return redirect()->route('transaction-products.index');
    }
}
