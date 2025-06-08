@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

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
                                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->unit }}</option>
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
      <!-- Menampilkan SweetAlert jika ada pesan sukses atau error -->
      @if (session('success'))
      <script>
          Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: '{{ session('success') }}',
          });
      </script>
  @endif

  @if ($errors->any())
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '{{ $errors->first() }}', // Menampilkan error pertama
          });
      </script>
  @endif
@endsection
