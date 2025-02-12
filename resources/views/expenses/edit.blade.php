@extends('layouts.app')

@section('title', 'Edit Pengeluaran')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Pengeluaran -->
                        <div class="form-group">
                            <label for="name">Nama Pengeluaran</label>
                            <input type="text" class="form-control" name="name" value="{{ $expense->name }}" required>
                        </div>

                        <!-- Kategori Pengeluaran -->
                        <div class="form-group">
                            <label for="category_expense_id">Kategori</label>
                            <select class="form-control" name="category_expense_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        @if($category->id == $expense->category_expense_id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jumlah Pengeluaran -->
                        <div class="form-group">
                            <label for="amount">Jumlah</label>
                            <input type="number" step="0.01" class="form-control" name="amount" value="{{ $expense->amount }}" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update Pengeluaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
