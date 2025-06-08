@extends('layouts.app')

@section('title', 'Data Produk')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{ route('products.create') }}" class="btn btn-outline-primary mb-3">Tambah</a>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-borderless" id="dataTable">
                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th class="text-nowrap">Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Diskon (%)</th>
                                    <th>Harga Setelah Diskon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{-- <img src="data:image/png;base64,{{ $barcodes[$product->id] }}" alt="Barcode"> --}}
                                            {{ $product->code }}
                                        </td>
                                        <td class="text-nowrap">{{ $product->name }}</td>
                                        <td>Rp. {{ number_format($product->sale_price, 0, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ number_format($product->discount, 0) }}%</td>
                                        <td>Rp. {{ number_format($product->final_price, 0, ',', '.') }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-warning mx-2">Edit</a>
                                            <form id="delete-form-{{ $product->id }}"
                                                action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $product->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script konfirmasi delete -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
