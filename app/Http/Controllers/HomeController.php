<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $countTransctionToday = Transaction::whereDate('created_at', Carbon::today())->count();
        $totalPriceToday = Transaction::whereDate('created_at', Carbon::today())->sum('total_payment');
        $totalQrisToday = Transaction::whereDate('created_at', Carbon::today())->where('payment_type', 'qris')->sum('total_payment');
        $totalCashToday = Transaction::whereDate('created_at', Carbon::today())->where('payment_type', 'cash')->sum('total_payment');

        $transactionsByHour = Transaction::whereDate('created_at', Carbon::today())
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $hours = [];
        $transactionData = [];

        for ($i = 0; $i < 24; $i++) {
            $formattedHour = sprintf('%02d:00', $i); 
            $hours[] = $formattedHour;
            $transactionData[] = $transactionsByHour[$i] ?? 0;
        }

        return view('home', compact(
            'countTransctionToday',
            'totalPriceToday',
            'totalQrisToday',
            'totalCashToday',
            'transactionData',
            'hours'
        ));
    }
}
