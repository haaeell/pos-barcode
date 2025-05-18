@extends('layouts.app')

@section('title', 'Data Produk')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('products.create') }}" class="btn btn-outline-primary mb-3">Tambah</a>
                    <table class="table table-striped table-hover table-borderless" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th class="text-nowrap">Harga Jual</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="data:image/png;base64,{{ $barcodes[$product->id] }}" alt="Barcode">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp. {{ number_format($product->sale_price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mx-2">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
