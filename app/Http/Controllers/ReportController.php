<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $tahunIni = Carbon::now()->year; 
        $transactions = Transaction::selectRaw('DATE_FORMAT(date, "%Y-%m") as bulan, SUM(total_payment) as total')
            ->whereYear('date', $tahunIni)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
    
        $expenses = Expense::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, SUM(amount) as total')
            ->whereYear('created_at', $tahunIni)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
    
        $labels = [];
        $omzet = [];
        $profit = [];
    
        for ($i = 1; $i <= 12; $i++) {
            $bulan = Carbon::create($tahunIni, $i, 1)->format('Y-m');
            $labels[] = $bulan; 
    
            $totalPendapatan = $transactions[$bulan] ?? 0;
            $totalPengeluaran = $expenses[$bulan] ?? 0;
    
            $omzet[] = $totalPendapatan;
            $profit[] = $totalPendapatan - $totalPengeluaran;
        }
    
        $bulanIni = Carbon::now()->format('Y-m');
        $pendapatan = $transactions[$bulanIni] ?? 0;
        $pengeluaran = $expenses[$bulanIni] ?? 0;
        $laba_bersih = $pendapatan - $pengeluaran;
    
        $laporan = [
            ['keterangan' => 'Total Pendapatan', 'jumlah' => $pendapatan],
            ['keterangan' => 'Total Pengeluaran', 'jumlah' => $pengeluaran],
            ['keterangan' => 'Laba Bersih', 'jumlah' => $laba_bersih],
        ];
    
        $total = $laba_bersih;
    
        return view('report.index', compact(
            'pendapatan', 'pengeluaran', 'laba_bersih',
            'labels', 'omzet', 'profit', 'laporan', 'total'
        ));
    }
    
} 