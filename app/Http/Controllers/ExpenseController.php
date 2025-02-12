<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\CategoryExpense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = CategoryExpense::all();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Expense::create($request->all());
        return redirect()->route('expenses.index');
    }

    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $categories = CategoryExpense::all();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return redirect()->route('expenses.index');
    }

    public function destroy($id)
    {
        Expense::destroy($id);
        return redirect()->route('expenses.index');
    }
}
