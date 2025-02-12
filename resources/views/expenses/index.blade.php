@extends('layouts.app')

@section('title', 'Data Pengeluaran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('expenses.create') }}" class="btn btn-outline-primary mb-3">Tambah Pengeluaran</a>
                    <table class="table table-striped table-hover table-borderless">
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
                                    <td>{{ $expense->amount }}</td>
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
