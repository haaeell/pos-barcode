<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function saveTransaction(Request $request)
    {
        DB::beginTransaction();

        try {
            $today = Carbon::now()->format('Ymd');
            $transactionCount = Transaction::whereDate('date', Carbon::today())->count();
            $sequenceNumber = str_pad($transactionCount + 1, 3, '0', STR_PAD_LEFT);
            $notaNumber =   'TRX-' . $today . '-' . $sequenceNumber;

            $transaction = new Transaction();
            $transaction->cashier_id = Auth::user()->id;
            $transaction->nota_number = $notaNumber;
            $transaction->date = Carbon::now();
            $transaction->payment_type = $request->payment_type;
            $transaction->total_payment = $request->total_payment;
            $transaction->save();

            foreach ($request->cart as $item) {
                $product = Product::find($item['id']);

                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Stok produk {$product->name} tidak cukup."
                    ]);
                }

                $product->stock -= $item['quantity'];
                $product->save();

                TransactionProduct::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'qty' => $item['quantity']
                ]);
            }

            DB::commit();

            $receiptData = [
                'transaction_id' => $transaction->nota_number,
                'cashier_name' => $transaction->cashier->name,
                'date' => $transaction->date->format('d-m-Y H:i:s'),
                'payment_type' => $transaction->payment_type,
                'total_payment' => $transaction->total_payment,
                'products' => []
            ];

            foreach ($request->cart as $item) {
                $product = Product::find($item['id']);
                $receiptData['products'][] = [
                    'name' => $product->name,
                    'price' => $product->sale_price,
                    'quantity' => $item['quantity'],
                    'total' => $product->sale_price * $item['quantity']
                ];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan',
                'receipt' => $receiptData
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan, coba lagi.',
                'error_details' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(), 
                    'file' => $e->getFile(),
                    'line' => $e->getLine() 
                ]
            ]);
        }
    }

    public function searchByBarcode(Request $request)
    {
        $product = Product::where('code', $request->barcode)->first();

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'products' => [$product]
        ]);
    }

    private function boyerMooreSearch($text, $pattern)
    {
        $m = strlen($pattern);  // Panjang pola (barcode)
        $n = strlen($text);     // Panjang teks (barcode produk)

        // Membuat tabel Bad Character Heuristic
        $badChar = array_fill(0, 256, -1); // Ukuran ASCII (256 karakter)

        // Mengisi tabel dengan posisi terakhir dari setiap karakter dalam pola
        for ($i = 0; $i < $m; $i++) {
            $badChar[ord($pattern[$i])] = $i;
        }

        $s = 0;
        $matches = [];

        while ($s <= ($n - $m)) {
            $j = $m - 1;

            // Terus kurangi $j selama karakter cocok
            while ($j >= 0 && $pattern[$j] == $text[$s + $j]) {
                $j--;
            }

            // Jika pola ditemukan
            if ($j < 0) {
                $matches[] = $s; // Mencatat posisi kecocokan
                $s += ($s + $m < $n) ? $m - $badChar[ord($text[$s + $m])] : 1;
            } else {
                $s += max(1, $j - $badChar[ord($text[$s + $j])]);
            }
        }

        return $matches;  // Mengembalikan daftar posisi kecocokan
    }
}
