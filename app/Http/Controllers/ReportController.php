<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan');

        // Query untuk grafik (terpengaruh hanya oleh tahun)
        $transactions = Transaction::selectRaw('DATE_FORMAT(date, "%Y-%m") as bulan, SUM(total_payment) as total')
            ->whereYear('date', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();

        $expenses = Expense::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, SUM(amount) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();

        // Data untuk grafik (menampilkan seluruh 12 bulan untuk tahun yang dipilih)
        $labels = [];
        $omzet = [];
        $profit = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanFormat = Carbon::create($tahun, $i, 1)->format('Y-m');
            $labels[] = $bulanFormat;
            $totalPendapatan = $transactions[$bulanFormat] ?? 0;
            $totalPengeluaran = $expenses[$bulanFormat] ?? 0;
            $omzet[] = $totalPendapatan;
            $profit[] = $totalPendapatan - $totalPengeluaran;
        }

        // Query untuk data selain grafik (terpengaruh oleh bulan jika ada filter)
        if ($bulan) {
            $transactionsQuery = Transaction::selectRaw('SUM(total_payment) as total')
                ->whereYear('date', $tahun)
                ->whereMonth('date', $bulan)
                ->first();

            $expensesQuery = Expense::selectRaw('SUM(amount) as total')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->first();
        } else {
            $transactionsQuery = Transaction::selectRaw('SUM(total_payment) as total')
                ->whereYear('date', $tahun)
                ->first();

            $expensesQuery = Expense::selectRaw('SUM(amount) as total')
                ->whereYear('created_at', $tahun)
                ->first();
        }

        $pendapatan = $transactionsQuery->total ?? 0;
        $pengeluaran = $expensesQuery->total ?? 0;
        $laba_bersih = $pendapatan - $pengeluaran;

        $laporan = [
            ['keterangan' => 'Total Pendapatan', 'jumlah' => $pendapatan],
            ['keterangan' => 'Total Pengeluaran', 'jumlah' => $pengeluaran],
            ['keterangan' => 'Laba Bersih', 'jumlah' => $laba_bersih],
        ];

        $total = $laba_bersih;

        return view('report.index', compact(
            'pendapatan',
            'pengeluaran',
            'laba_bersih',
            'labels',
            'omzet',
            'profit',
            'laporan',
            'total'
        ));
    }
}
