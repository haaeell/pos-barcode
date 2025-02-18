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
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#productDetailsModal{{ $item->id }}">
                                            Detail Produk
                                        </button>
                                    </td>
                                    <td>{{ $item->payment_type }}</td>
                                    <td>{{ $item->total_payment }}</td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="productDetailsModal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="productDetailsModalLabel">Detail Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Produk</th>
                                                            <th>Jumlah</th>
                                                            <th>Harga Satuan</th>
                                                            <th>Harga Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($item->transactionProducts as $product)
                                                            <tr>
                                                                <td>{{ $product->product->name }}</td>
                                                                <td>{{ $product->qty }}</td>
                                                                <td>Rp {{ number_format($product->product->sale_price, 0, ',', '.') }}</td>
                                                                <td>Rp {{ number_format($product->product->sale_price * $product->qty, 0, ',', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
