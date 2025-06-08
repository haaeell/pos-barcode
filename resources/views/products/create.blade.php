@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="code">Kode Produk</label>
                            <input type="text" class="form-control" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="sale_price">Harga Jual</label>
                            <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="discount">Diskon (%)</label>
                            <input type="number" step="0.01" class="form-control" id="discount" name="discount"
                                placeholder="0.00">
                        </div>

                        <div class="form-group">
                            <label for="discount_value">Potongan (Rp)</label>
                            <input type="text" class="form-control" id="discount_value" readonly>
                        </div>

                        <div class="form-group">
                            <label for="final_price">Harga Setelah Diskon</label>
                            <input type="text" class="form-control" id="final_price" readonly>
                        </div>
                        <div class="form-group">
                            <label for="unit">Satuan</label>
                            <select class="form-control" name="unit" id="unit" required>
                                <option value="">-- Pilih Satuan --</option>
                                <option value="pcs">pcs</option>
                                <option value="dus">dus</option>
                                <option value="kg">kg</option>
                                <option value="liter">liter</option>
                                <option value="box">box</option>
                                <option value="pack">pack</option>
                                <option value="botol">botol</option>
                                <option value="karton">karton</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="stock">Stok awal</label>
                            <input type="number" class="form-control" value="0" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Harga Beli</label>
                            <input type="number" class="form-control" value="0" name="purchase_price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateDiscountInfo() {
            const price = parseFloat(document.getElementById('sale_price').value) || 0;
            const discount = parseFloat(document.getElementById('discount').value) || 0;

            const discountAmount = (price * discount / 100).toFixed(2);
            const finalPrice = (price - discountAmount).toFixed(2);

            document.getElementById('discount_value').value = formatRupiah(discountAmount);
            document.getElementById('final_price').value = formatRupiah(finalPrice);
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        document.getElementById('discount').addEventListener('input', updateDiscountInfo);
        document.getElementById('sale_price').addEventListener('input', updateDiscountInfo);
    </script>

@endsection
