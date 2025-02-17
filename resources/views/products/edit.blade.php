@extends('layouts.app')

@section('title','Edit Produk')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="code">Kode Produk</label>
                            <input type="text" class="form-control" value="{{ $product->code }}" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" class="form-control" name="name"  value="{{ $product->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="sale_price">Harga Jual</label>
                            <input type="number" step="0.01" class="form-control" name="sale_price"  value="{{ $product->sale_price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="unit">Satuan</label>
                            <input type="text" class="form-control" name="unit"  value="{{ $product->unit }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $product->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
