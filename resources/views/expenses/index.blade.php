@extends('layouts.app')

@section('title', 'Data Pengeluaran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <a href="{{ route('expenses.create') }}" class="btn btn-outline-primary mb-3">Tambah Pengeluaran</a>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('expenses.index') }}" method="get">
                                <div class="row">
                                    <div class="col">
                                        <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Tanggal">
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
                    <table class="table table-striped table-hover table-borderless" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengeluaran</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ $expense->category->name }}</td>
                                    <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
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
