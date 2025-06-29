@extends('layouts.app')

@section('title', 'Data Produk')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Tombol Import (Buka Modal) -->
                    <button type="button" class="btn btn-outline-info mb-3" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-file-import"></i> Import Produk
                    </button>

                    <!-- Tombol Tambah Produk -->
                    <a href="{{ route('products.create') }}" class="btn btn-outline-primary mb-3 ml-2">
                        <i class="fas fa-plus"></i> Tambah
                    </a>

                    <!-- Modal Import (Bootstrap 4) -->
                    <div class="modal fade" id="importModal" tabindex="-1" role="dialog"
                        aria-labelledby="importModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('products.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">Upload File Excel:</label>
                                            <div class="input-group">
                                                <input type="file" name="file" class="form-control" accept=".xlsx"
                                                    required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <a href="{{ route('products.export-template') }}" class="btn btn-outline-success mb-3">
                                        <i class="fas fa-download"></i> Download Format Excel
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-borderless" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>Barcode</th> --}}
                                    <th>Name</th>
                                    <th class="text-nowrap">Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    {{-- <th>Diskon (%)</th> --}}
                                    {{-- <th>Harga Setelah Diskon</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td> --}}
                                            {{-- <img src="data:image/png;base64,{{ $barcodes[$product->id] }}" alt="Barcode"> --}}
                                            {{-- {{ $product->code }} --}}
                                        {{-- </td> --}}
                                        <td class="text-nowrap">{{ $product->name }}</td>
                                        <td>Rp. {{ number_format($product->sale_price, 0, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        {{-- <td>{{ number_format($product->discount, 0) }}%</td> --}}
                                        {{-- <td>Rp. {{ number_format($product->final_price, 0, ',', '.') }}</td> --}}
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
