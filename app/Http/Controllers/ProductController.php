<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $generator = new BarcodeGeneratorPNG();

        $barcodes = [];

        foreach ($products as $product) {
            $barcodes[$product->id] = base64_encode($generator->getBarcode($product->code, BarcodeGeneratorPNG::TYPE_CODE_128));
        }

        return view('products.index', compact('products', 'barcodes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sale_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create([
            'code' => $request->code,
            'stock' => 0,
            'name' => $request->name,
            'sale_price' => $request->sale_price,
            'unit' => $request->unit,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
