@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="omzetProfitChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center my-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold text-start">
                        Pendapatan
                    </h4>
                    <span>Rp. 23.000.000</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold text-start">
                        Pengeluaran
                    </h4>
                    <span>Rp. 23.000.000</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold text-start">
                        Laba Bersih
                    </h4>
                    <span>Rp. 11.000.000</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center my-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">
                        Laporan Laba Rugi
                    </h4>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Pendapatan</td>
                                <td>Rp. 12.000.000 </td>
                            </tr>
                            <tr>
                                <td>Gaji Kaaryawan</td>
                                <td>Rp. 12.000.000 </td>
                            </tr>
                            <tr>
                                <td>Belanja</td>
                                <td>Rp. 12.000.000 </td>
                            </tr>
                            <tr>
                                <td>Biaya Operasional</td>
                                <td>Rp. 12.000.000 </td>
                            </tr>
                            <tr class="bg-dark text-white">
                                <td>Total</td>
                                <td>Rp. 12.000.000 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('omzetProfitChart').getContext('2d');
        const omzetProfitChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                        label: 'Omzet',
                        data: [5000000, 7000000, 8000000, 6000000, 7500000, 9000000],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Profit',
                        data: [1500000, 2000000, 2500000, 1800000, 2200000, 2700000],
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Omzet dan Profit Bulanan'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
