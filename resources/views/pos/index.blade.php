@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')
    <style>
        .select2-results__option:hover {
            background-color: #007bff !important;
            color: white !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff !important;
            color: white !important;
        }
        
    </style>


    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="posApp">
                        <label for="productSearch">Scan Barcode / Cari Produk:</label>
                        <select id="productSearch" class="form-control"></select>
                        <input type="text" id="barcodeScanner" class="form-control my-2"
                            placeholder="Scan barcode di sini..." autofocus>


                        <h7 class="mb-3 mt-5">Data Produk:</h7>
                        <table class="table table-bordered" id="productTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Produk</th>
                                    <th class="text-center">Sisa Stok</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Total Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div id="errorMessage" style="color:red; display:none;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3>Informasi Pembayaran</h3>
                    <p class="font-weight-bold">Total: Rp. <span id="totalAmount">0</span></p>
                    <div class="mb-3">
                        <label for="paymentMethod">Tipe Pembayaran:</label>
                        <select id="paymentMethod" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="qris">Qris</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amountPaid">Jumlah Dibayar:</label>
                        <input type="number" id="amountPaid" class="form-control" placeholder="Masukkan Jumlah Dibayar"
                            min="0">
                    </div>

                    <div class="mb-3">
                        <label for="change">Total Kembalian:</label>
                        <input type="text" id="change" class="form-control" placeholder="Kembalian" readonly>
                    </div>
                    <button id="saveTransaction" class="btn btn-primary mt-3" disabled>Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Struk -->
    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Struk Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="receiptContent">
                    <!-- Konten struk akan ditampilkan di sini -->
                </div>
                <div class="modal-footer" id="saveReceipt">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="printReceipt">Cetak Struk</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let cart = [];
            let totalAmount = 0;

            $('#productSearch').select2({
                placeholder: 'Cari Produk...',
                minimumInputLength: 1,
                ajax: {
                    url: '/pos/search-product',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.products.map(product => ({
                                id: product.id,
                                text: `${product.name} - ${formatRupiah(product.sale_price)}`,
                                price: product.sale_price,
                                stock: product.stock,
                            }))
                        };
                    }
                }
            });

            $('#barcodeScanner').on('keypress', function(event) {
                if (event.which === 13) {
                    let barcode = $(this).val().trim();
                    if (barcode !== '') {
                        addToCart(barcode);
                        $(this).val('');
                    }
                }
            });

            function addToCart(barcode) {
                $.ajax({
                    url: '/pos/get-product',
                    method: 'GET',
                    data: {
                        barcode: barcode
                    },
                    success: function(response) {
                        if (response.success) {
                            let product = response.product;
                            let existingItem = cart.find(item => item.id === product.id);

                            if (existingItem) {
                                existingItem.quantity += 1;
                            } else {
                                cart.push({
                                    id: product.id,
                                    name: product.name,
                                    stock: product.stock,
                                    price: product.price,
                                    quantity: 1
                                });
                            }

                            updateProductTable();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Produk tidak ditemukan!',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }

            function updateProductTable() {
                let productTable = $('#productTable tbody');
                productTable.empty();
                totalAmount = 0;

                cart.forEach((item, index) => {
                    let itemTotal = item.price * item.quantity;
                    totalAmount += itemTotal;
                    productTable.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>${item.stock}</td>
                    <td>${formatRupiah(item.price)}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-primary minus-btn" data-id="${item.id}">-</button>
                            <input type="number" class="quantity-input form-control mx-2" data-id="${item.id}" value="${item.quantity}" min="1">
                            <button class="btn btn-sm btn-primary plus-btn" data-id="${item.id}">+</button>
                        </div>
                    </td>
                    <td>${formatRupiah(itemTotal)}</td>
                    <td><button class="btn btn-sm btn-danger remove-btn" data-id="${item.id}">Hapus</button></td>
                </tr>
            `);
                });

                $('#totalAmount').text(formatRupiah(totalAmount));
                checkSaveButtonStatus();
            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka);
            }

            function checkSaveButtonStatus() {
                let amountPaid = parseFloat($('#amountPaid').val()) || 0;
                if (amountPaid >= totalAmount && totalAmount > 0) {
                    $('#saveTransaction').prop('disabled', false);
                    $('#change').val(formatRupiah(amountPaid - totalAmount));
                } else {
                    $('#saveTransaction').prop('disabled', true);
                    $('#change').val('');
                }
            }

            $('#amountPaid').on('input', checkSaveButtonStatus);

            $(document).on('click', '.plus-btn', function() {
                let productId = $(this).data('id');
                let product = cart.find(item => item.id === productId);
                if (product) {
                    product.quantity += 1;
                    totalAmount += product.price;
                    updateProductTable();
                }
            });

            $(document).on('click', '.minus-btn', function() {
                let productId = $(this).data('id');
                let product = cart.find(item => item.id === productId);
                if (product && product.quantity > 1) {
                    product.quantity -= 1;
                    totalAmount -= product.price;
                    updateProductTable();
                }
            });

            $(document).on('keyup', '.quantity-input', _.debounce(function() {
                let productId = $(this).data('id');
                let newQuantity = parseInt($(this).val()) || 1;
                let product = cart.find(item => item.id === productId);

                if (product) {
                    if (newQuantity < 1) newQuantity = 1;
                    product.quantity = newQuantity;
                    updateProductTable();
                }
            }, 300));

            $(document).on('click', '.remove-btn', function() {
                let productId = $(this).data('id');
                cart = cart.filter(item => item.id !== productId);
                updateProductTable();
            });

            $('#productSearch').on('select2:select', function(e) {
                let productId = e.params.data.id;
                let productName = e.params.data.text.split(" - ")[0];
                let productPrice = parseFloat(e.params.data.price);
                let productStock = e.params.data.stock;


                let existingProduct = cart.find(item => item.id === productId);
                if (existingProduct) {
                    existingProduct.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        stock: productStock,
                        quantity: 1
                    });
                }

                updateProductTable();
                $('#productSearch').val(null).trigger('change');
            });

            $('#saveTransaction').click(function() {
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Tidak ada produk dalam keranjang!',
                        confirmButtonText: 'OK'
                    });

                    return;
                }

                let paymentMethod = $('#paymentMethod').val();
                let amountPaid = parseFloat($('#amountPaid').val());

                $.ajax({
                    url: '/pos/save-transaction',
                    method: 'POST',
                    data: {
                        cart: cart,
                        total_payment: totalAmount,
                        amountPaid: amountPaid,
                        payment_type: paymentMethod
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            displayReceipt(response.receipt);

                            cart = [];
                            totalAmount = 0;
                            updateProductTable();

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });

                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan, coba lagi.!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

           function displayReceipt(receipt) {
    let receiptHtml = `<pre>`;
    receiptHtml += `Nota    : ${receipt.transaction_id}\n`;
    receiptHtml += `Kasir   : ${receipt.cashier_name}\n`;
    receiptHtml += `Tanggal : ${receipt.date}\n`;
    receiptHtml += `Bayar   : ${receipt.payment_type}\n`;

    receiptHtml += `----------------------------------------\n`;

    receipt.products.forEach(product => {
        const name = (product.name ?? '').slice(0, 30);
        const discount = product.discount && product.discount > 0 ? ` (${product.discount}%)` : '';
        const qty = product.quantity;
        const price = new Intl.NumberFormat('id-ID').format(product.price);
        const total = new Intl.NumberFormat('id-ID').format(product.total);

        // Baris 1: Nama Produk (Diskon)
        receiptHtml += `${name}${discount}\n`;

        // Baris 2: qty x harga       total di kanan
        const qtyPrice = `${qty}x${price}`;
        const left = ' '.repeat(5) + qtyPrice;
        const spaceBetween = 40 - left.length - total.length;
        const right = ' '.repeat(spaceBetween > 0 ? spaceBetween : 1) + total;

        receiptHtml += `${left}${right}\n`;
    });

    receiptHtml += `----------------------------------------\n`;

    // Baris total pembayaran rata kanan
    const totalText = 'Total Pembayaran :';
    const totalValue = `Rp ${new Intl.NumberFormat('id-ID').format(receipt.total_payment)}`;
    const space = 40 - totalText.length - totalValue.length;
    receiptHtml += `${totalText}${' '.repeat(space > 0 ? space : 1)}${totalValue}\n`;

    receiptHtml += `----------------------------------------\n`;
    receiptHtml += `       Terima kasih atas kunjungannya\n`;
    receiptHtml += `</pre>`;

    $('#receiptContent').html(receiptHtml);
    $('#receiptModal').modal('show');
}

        });

        $(document).on('click', '#printReceipt', function() {
            let printContents = document.getElementById('receiptContent').innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        });
    </script>
@endpush
