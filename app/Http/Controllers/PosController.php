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
    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")->limit(5)->get();

        if ($products->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        }

        return response()->json(['status' => 'success', 'products' => $products]);
    }

    public function getProduct(Request $request)
    {
        $products = Product::all()->pluck('code', 'id')->toArray();
        $barcode = $request->barcode;

        $foundId = $this->boyerMooreSearch($products, $barcode);

        if ($foundId !== null) {
            $product = Product::find($foundId);
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->sale_price
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }

    private function boyerMooreSearch($products, $pattern)
    {
        foreach ($products as $id => $code) {
            if ($this->boyerMoore($code, $pattern)) {
                return $id;
            }
        }
        return null;
    }

    private function boyerMoore($text, $pattern)
    {
        $m = strlen($pattern);
        $n = strlen($text);
        if ($m > $n) return false;

        $badChar = array_fill(0, 256, -1);
        for ($i = 0; $i < $m; $i++) {
            $badChar[ord($pattern[$i])] = $i;
        }

        $shift = 0;
        while ($shift <= ($n - $m)) {
            $j = $m - 1;

            while ($j >= 0 && $pattern[$j] == $text[$shift + $j]) {
                $j--;
            }

            if ($j < 0) {
                return true;
            }

            $shift += max(1, $j - $badChar[ord($text[$shift + $j])]);
        }
        return false;
    }

}
