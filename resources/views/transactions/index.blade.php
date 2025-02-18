@extends('layouts.app')

@section('title', 'Data Riwayat Transaksi')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover table-borderless">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Nota</th>
                                <th>Tanggal</th>
                                <th>Detail</th>
                                <th>Tipe Pembayaran</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                   <td>{{ $loop->iteration }}</td>
                                   <td>{{ $item->nota_number }}</td>
                                   <td>{{ $item->created_at }}</td>
                                   <td><button class="btn btn-primary btn-sm">Detail Produk</button></td>
                                   <td>{{ $item->payment_type }}</td>
                                   <td>{{ $item->total_payment }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
