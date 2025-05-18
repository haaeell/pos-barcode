@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('report.index') }}" class="row mb-4">
                        <div class="col-md-3">
                            <label for="tahun">Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control"
                                value="{{ request('tahun', now()->year) }}" placeholder="Tahun">
                        </div>

                        <div class="col-md-3">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">Semua Bulan</option>
                                @foreach (range(1, 12) as $bln)
                                    <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $bln)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    <h4 class="font-weight-bold text-start">Pendapatan</h4>
                    <span>Rp. {{ number_format($pendapatan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold text-start">Pengeluaran</h4>
                    <span>Rp. {{ number_format($pengeluaran, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold text-start">Laba Bersih</h4>
                    <span>Rp. {{ number_format($laba_bersih, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center my-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">Laporan Laba Rugi</h4>
                    <table class="table">
                        <tbody>
                            @foreach ($laporan as $item)
                                <tr>
                                    <td>{{ $item['keterangan'] }}</td>
                                    <td>Rp. {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-dark text-white">
                                <td>Total</td>
                                <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
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
                labels: {!! json_encode($labels) !!},
                datasets: [{
                        label: 'Omzet',
                        data: {!! json_encode($omzet) !!},
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Profit',
                        data: {!! json_encode($profit) !!},
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
