@extends('layouts.app')

@section('title', 'Data Belanja')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <a href="{{ route('product-incomes.create') }}" class="btn btn-outline-primary">Tambah Barang Masuk</a>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('product-incomes.index') }}" method="get">
                                <div class="row">
                                    <div class="col">
                                        <input type="date" name="date" class="form-control" placeholder="Tanggal">
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-borderless">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Harga Total</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name }} - {{ $item->product->unit }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->purchase_price / $item->qty, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                                    <td>
                                        <a href="{{ route('product-incomes.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('product-incomes.destroy', $item->id) }}" method="POST" style="display:inline;">
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
