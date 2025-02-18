@extends('layouts.app')

@section('title', 'Data Produk')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="posApp">
                        <label for="barcode">Scan Barcode:</label>
                        <input type="text" id="barcode" name="barcode" class="form-control" autocomplete="off" autofocus>
                        <h3 class="mb-3 mt-5">Data Produk:</h3>
                        <table class="table table-bordered" id="productTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Produk</th>
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
                        <input type="number" id="change" class="form-control" placeholder="Kembalian" readonly>
                    </div>
                    <button id="saveTransaction" type="submit" class="btn btn-primary mt-3" disabled>Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Struk Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="receiptContent">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="printReceipt">Cetak Struk</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let cart = [];
            let totalAmount = 0;
            let debounceTimeout;

            function updateProductTable() {
                $('#productTable tbody').empty();
                cart.forEach(item => {
                    $('#productTable tbody').append(`
                    <tr>
                        <td>${item.name}</td>
                        <td>Rp. ${item.price}</td>
                        <td>
                            <div class="d-flex gap-2 align-items-center justify-content-center">
                                <button class="btn btn-sm btn-primary minus-btn" data-id="${item.id}">-</button>
                                <input type="number" class="quantity-input form-control w-25 mx-2" data-id="${item.id}" value="${item.quantity}" min="0">
                                <button class="btn btn-sm btn-primary plus-btn" data-id="${item.id}">+</button>
                            </div>
                        </td>
                        <td>Rp. ${item.price * item.quantity}</td>
                        <td><button class="btn btn-sm btn-danger remove-btn" data-id="${item.id}">Remove</button></td>
                    </tr>
                `);
                });
                $('#totalAmount').text(totalAmount.toFixed(2));
                checkSaveButtonStatus();
            }

            function checkSaveButtonStatus() {
                let amountPaid = parseFloat($('#amountPaid').val()) || 0;
                if (amountPaid >= totalAmount) {
                    $('#saveTransaction').prop('disabled', false);
                    $('#change').val((amountPaid - totalAmount).toFixed(2));
                } else {
                    $('#saveTransaction').prop('disabled', true);
                    $('#change').val('');
                }
            }

            $('#barcode').on('change', function() {
                var barcode = $(this).val();
                console.log(barcode);
                if (barcode.length === 0) {
                    $('#errorMessage').hide();
                    return;
                }

                clearTimeout(debounceTimeout);

                debounceTimeout = setTimeout(function() {
                    $.ajax({
                        url: '/pos/search',
                        method: 'POST',
                        data: {
                            barcode: barcode,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == 'success' && response.products
                                .length > 0) {
                                var product = response.products[0];
                                let existingProduct = cart.find(item => item.id ===
                                    product.id);
                                if (existingProduct) {
                                    existingProduct.quantity += 1;
                                } else {
                                    cart.push({
                                        id: product.id,
                                        name: product.name,
                                        price: product.sale_price,
                                        quantity: 1
                                    });
                                }
                                totalAmount += parseFloat(product.sale_price);
                                updateProductTable();
                                $('#barcode').val('');
                                $('#errorMessage').hide();
                            } else {
                                $('#errorMessage').text(response.message).show();
                            }
                        },
                        error: function() {
                            $('#errorMessage').text('Terjadi kesalahan. Coba lagi.')
                                .show();
                        }
                    });
                }, 200);
            });

            $(document).on('click', '.plus-btn', function() {
                let productId = $(this).data('id');
                let product = cart.find(item => item.id === productId);
                if (product) {
                    product.quantity += 1;
                    totalAmount += parseFloat(product.price);
                    updateProductTable();
                }
            });

            $(document).on('click', '.minus-btn', function() {
                let productId = $(this).data('id');
                let product = cart.find(item => item.id === productId);
                if (product && product.quantity > 1) {
                    product.quantity -= 1;
                    totalAmount -= parseFloat(product.price);
                    updateProductTable();
                }
            });

            $(document).on('change', '.quantity-input', function() {
                let productId = $(this).data('id');
                let newQuantity = parseInt($(this).val());
                let product = cart.find(item => item.id === productId);
                if (product && newQuantity >= 0) {
                    totalAmount -= parseFloat(product.price) * product.quantity;
                    product.quantity = newQuantity;
                    totalAmount += parseFloat(product.price) * newQuantity;
                    updateProductTable();
                }
            });

            $(document).on('click', '.remove-btn', function() {
                let productId = $(this).data('id');
                let product = cart.find(item => item.id === productId);
                if (product) {
                    totalAmount -= parseFloat(product.price) * product.quantity;
                    cart = cart.filter(item => item.id !== productId);
                    updateProductTable();
                }
            });

            $('#amountPaid').on('input', function() {
                checkSaveButtonStatus();
            });

            $('#saveTransaction').on('click', function() {
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Tidak ada produk yang dipilih.',
                        confirmButtonText: 'OK'
                    });

                    return;
                }

                let paymentMethod = $('#paymentMethod').val();
                let totalAmount = parseFloat($('#totalAmount').text());
                let amountPaid = parseFloat($('#amountPaid').val());

                $.ajax({
                    url: '/pos/save-transaction',
                    method: 'POST',
                    data: {
                        payment_type: paymentMethod,
                        total_payment: totalAmount,
                        cart: cart.map(item => ({
                            id: item.id,
                            quantity: item.quantity
                        })),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {

                            displayReceipt(response.receipt);

                            cart = [];
                            totalAmount = 0;
                            updateProductTable();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Transaksi berhasil diproses.',
                                confirmButtonText: 'OK'
                            });
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
                let receiptHtml = `
        <p>ID Transaksi: ${receipt.nota_nummber}</p>
        <p>Kasir: ${receipt.cashier_name}</p>
        <p>Tanggal: ${receipt.date}</p>
        <p>Tipe Pembayaran: ${receipt.payment_type}</p>
        <p>Total Pembayaran: Rp. ${receipt.total_payment}</p>
        <h5>Detail Produk:</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
    `;

                receipt.products.forEach(product => {
                    receiptHtml += `
            <tr>
                <td>${product.name}</td>
                <td>Rp. ${product.price}</td>
                <td>${product.quantity}</td>
                <td>Rp. ${product.total}</td>
            </tr>
        `;
                });

                receiptHtml += `
            </tbody>
        </table>
    `;

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
