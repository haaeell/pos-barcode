<?php

namespace App\Http\Controllers;

use App\Models\CategoryExpense;
use Illuminate\Http\Request;

class CategoryExpenseController extends Controller
{
    public function index()
    {
        $categories = CategoryExpense::all();
        return view('categories-expense.index', compact('categories'));
    }

    public function create()
    {
        return view('categories-expense.create');
    }

    public function store(Request $request)
    {
        CategoryExpense::create($request->all());
        return redirect()->route('categories-expense.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $category = CategoryExpense::findOrFail($id);
        return view('categories-expense.show', compact('category'));
    }

    public function edit($id)
    {
        $category = CategoryExpense::findOrFail($id);
        return view('categories-expense.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = CategoryExpense::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('categories-expense.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        CategoryExpense::destroy($id);
        return redirect()->route('categories-expense.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
