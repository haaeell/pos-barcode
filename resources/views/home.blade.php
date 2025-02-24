@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12 text-start">
            <h4 class="fw-bold">
                <span id="currentDay"></span>, <span id="currentTime"></span> WIB
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card shadow eq-card mb-4">
                <div class="card-body mb-n3">
                    <div class="row items-align-baseline align-items-center text-center h-100">
                        <div class="col-md-6 my-3">
                            <i class="fe fe-shopping-cart text-dark mb-3" style="font-size: 70px"></i>
                            <h5 class="mt-4">Total Transaksi Hari Ini</h5>
                        </div>
                        <div class="col-md-6 my-4 text-center">
                            <h2 class="font-weight-bold" style="font-size: 50px">
                                {{ $countTransctionToday }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card shadow eq-card mb-4">
                <div class="card-body mb-n3">
                    <div class="row items-align-baseline align-items-center text-center h-100">
                        <div class="col-md-12 my-4 text-center">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>QRIS</th>
                                        <th>Cash</th>
                                    </tr>
                                    <tr>
                                        <td class="text-primary font-weight-bold fs-2" style="font-size: 20px">Rp
                                            {{ number_format($totalQrisToday, 0, ',', '.') }}</td>
                                        <td class="text-success font-weight-bold fs-4" style="font-size: 20px">Rp
                                            {{ number_format($totalCashToday, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h5 class="mt-2">Total Pendapatan Hari Ini</h5>
                            <h2 class="font-weight-bold mt-3" style="font-size: 30px">
                                Rp {{ number_format($totalPriceToday, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="mb-2 align-items-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="text-center">Grafik Transaksi per Jam</h5>
                <canvas id="transactionChart"></canvas>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        function updateDateTime() {
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const now = new Date();

            let dayName = days[now.getDay()];
            let hours = now.getHours().toString().padStart(2, '0');
            let minutes = now.getMinutes().toString().padStart(2, '0');
            let seconds = now.getSeconds().toString().padStart(2, '0');

            document.getElementById('currentDay').innerText = dayName;
            document.getElementById('currentTime').innerText = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var transactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($hours) !!}, // Jam 0 - 23
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: {!! json_encode($transactionData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
