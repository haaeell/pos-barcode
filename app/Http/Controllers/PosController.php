<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

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
                    'product_name' => $product->name,
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
                    'total' => $product->sale_price * $item['quantity'],
                    'discount' => $product->discount,
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
        $query = strtolower($request->input('query')); 
        $products = Product::all();
        $matchedProducts = [];

        foreach ($products as $product) {
            $productName = strtolower($product->name);
            if ($this->boyerMoore($productName, $query)) {
                $matchedProducts[] = $product;
            }
        }

        if (empty($matchedProducts)) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
        }

        $response = [];
        foreach ($matchedProducts as $product) {
            $response[] = [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'sale_price' => $product->final_price,
                'stock' => $product->stock,
                'discount' => $product->discount,
                'price' => $product->sale_price,
            ];
        }

        return response()->json(['status' => 'success', 'products' => $response]);
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
                    'price' => $product->final_price,
                    'stock' => $product->stock,
                    'discount' => $product->discount,
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }

    // public function getProduct($barcode)
    // {
    //     $product = Product::where('code', $barcode)->first();

    //     if ($product) {
    //         return response()->json([
    //             'success' => true,
    //             'product' => [
    //                 'id' => $product->id,
    //                 'name' => $product->name,
    //                 'price' => $product->sale_price,
    //                 'stock' => $product->stock,
    //             ]
    //         ]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']);
    // }

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

        // === 1. BAD CHARACTER  ===
        $badChar = array_fill(0, 256, -1);
        for ($i = 0; $i < $m; $i++) {
            $badChar[ord($pattern[$i])] = $i;
        }

        // === 2. GOOD SUFFIX  ===
        $goodSuffix = array_fill(0, $m + 1, 0);
        $border = array_fill(0, $m + 1, 0);
        $i = $m;
        $j = $m + 1;
        $border[$i] = $j;

        while ($i > 0) {
            while ($j <= $m && $pattern[$i - 1] != $pattern[$j - 1]) {
                if ($goodSuffix[$j] == 0) {
                    $goodSuffix[$j] = $j - $i;
                }
                $j = $border[$j];
            }
            $i--;
            $j--;
            $border[$i] = $j;
        }

        $j = $border[0];
        for ($i = 0; $i <= $m; $i++) {
            if ($goodSuffix[$i] == 0) {
                $goodSuffix[$i] = $j;
            }
            if ($i == $j) {
                $j = $border[$j];
            }
        }
        
        // === 3. Pencocokan dengan Boyer-Moore ===
        $s = 0; // shift
        while ($s <= $n - $m) {
            $j = $m - 1;

          
            while ($j >= 0 && $pattern[$j] == $text[$s + $j]) {
                $j--;
            }

            if ($j < 0) {
                return true; 
            } else {
                $badCharShift = $j - $badChar[ord($text[$s + $j])] ?? -1;
                $goodSuffixShift = $goodSuffix[$j + 1];
                $s += max(1, max($badCharShift, $goodSuffixShift));
            }
        }

        return false;
    }


    public function testSearchPerformance(Request $request)
    {
        $barcodes = $request->input('barcodes', []);

        $allProducts = Product::all();
        $results = [];

        foreach ($barcodes as $barcode) {
            // Native Search
            $native_start = microtime(true);
            $product_native = Product::where('code', $barcode)->first();
            $native_end = microtime(true);
            $native_time = round($native_end - $native_start, 5);

            // Boyer-Moore Search
            $boyer_start = microtime(true);
            $product_boyer = null;
            foreach ($allProducts as $product) {
                if ($this->boyerMoore($product->code, $barcode)) {
                    $product_boyer = $product;
                    break;
                }
            }
            $boyer_end = microtime(true);
            $boyer_time = round($boyer_end - $boyer_start, 5);

            $results[] = [
                'barcode' => $barcode,
                'native_time' => number_format($native_time, 9),
                'boyer_time' => number_format($boyer_time, 9),
            ];
        }

        return response()->json([
            'status' => 'success',
            'results' => $results
        ]);
    }

    public function getProducts(Request $request)
    {
        $limit = $request->query('limit', 10);
        $barcodes = Product::limit($limit)->pluck('code')->toArray();

        return response()->json([
            'barcodes' => $barcodes
        ]);
    }
}
