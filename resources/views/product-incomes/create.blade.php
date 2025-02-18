@extends('layouts.app')

@section('title', 'Tambah Pengeluaran')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('product-incomes.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">Produk</label>
                            <select class="form-control select2" name="product_id" required>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Jumlah</label>
                            <input type="number" step="1" class="form-control" name="qty" required>
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Harga Total</label>
                            <input type="number"  class="form-control" name="purchase_price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
