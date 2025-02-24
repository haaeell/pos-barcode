<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('cashier');
        
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('created_at', $request->date);
        }    

        $data = $query->get();
        return view('transactions.index', compact('data'));
    }

    public function create()
    {
        $cashiers = User::where('role', 'kasir')->get();
        return view('transactions.create', compact('cashiers'));
    }

    public function store(Request $request)
    {
        Transaction::create($request->all());
        return redirect()->route('transactions.index');
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $cashiers = User::where('role', 'kasir')->get();
        return view('transactions.edit', compact('transaction', 'cashiers'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return redirect()->route('transactions.index');
    }

    public function destroy($id)
    {
        Transaction::destroy($id);
        return redirect()->route('transactions.index');
    }
}
