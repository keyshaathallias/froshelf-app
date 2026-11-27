<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sku' => 'required|string|unique:products,kode_sku',
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga_normal' => 'required|numeric|min:0',
            'harga_reseller' => 'required|numeric|min:0',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'tanggal_expired' => 'required|date',
            'lokasi_penyimpanan' => 'required|in:Freezer 1,Freezer 2,Gudang Kering',
        ], [
            'kode_sku.required' => 'Kode SKU wajib diisi.',
            'kode_sku.string' => 'Kode SKU harus berupa teks.',
            'kode_sku.unique' => 'Kode SKU ini sudah digunakan, silakan buat yang lain.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.string' => 'Nama produk harus berupa teks.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'harga_normal.required' => 'Harga normal wajib diisi.',
            'harga_normal.numeric' => 'Harga normal harus berupa angka (tanpa huruf atau simbol).',
            'harga_normal.min' => 'Harga normal tidak boleh minus.',
            'harga_reseller.required' => 'Harga reseller wajib diisi.',
            'harga_reseller.numeric' => 'Harga reseller harus berupa angka (tanpa huruf atau simbol).',
            'harga_reseller.min' => 'Harga reseller tidak boleh minus.',
            'stok_saat_ini.required' => 'Stok saat ini wajib diisi.',
            'stok_saat_ini.integer' => 'Stok saat ini harus berupa angka bulat.',
            'stok_saat_ini.min' => 'Stok saat ini tidak boleh minus.',
            'stok_minimum.required' => 'Stok minimum wajib diisi.',
            'stok_minimum.integer' => 'Stok minimum harus berupa angka bulat.',
            'stok_minimum.min' => 'Stok minimum tidak boleh minus.',
            'tanggal_expired.required' => 'Tanggal expired wajib diisi.',
            'tanggal_expired.date' => 'Format tanggal expired tidak valid.',
            'lokasi_penyimpanan.required' => 'Lokasi penyimpanan wajib dipilih.',
            'lokasi_penyimpanan.in' => 'Lokasi penyimpanan tidak valid.',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'kode_sku' => 'required|string|unique:products,kode_sku,' . $product->id,
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga_normal' => 'required|numeric|min:0',
            'harga_reseller' => 'required|numeric|min:0',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'tanggal_expired' => 'required|date',
            'lokasi_penyimpanan' => 'required|in:Freezer 1,Freezer 2,Gudang Kering',
        ], [
            'kode_sku.required' => 'Kode SKU wajib diisi.',
            'kode_sku.string' => 'Kode SKU harus berupa teks.',
            'kode_sku.unique' => 'Kode SKU ini sudah digunakan.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.string' => 'Nama produk harus berupa teks.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'harga_normal.required' => 'Harga normal wajib diisi.',
            'harga_normal.numeric' => 'Harga normal harus berupa angka (tanpa huruf atau simbol).',
            'harga_normal.min' => 'Harga normal tidak boleh minus.',
            'harga_reseller.required' => 'Harga reseller wajib diisi.',
            'harga_reseller.numeric' => 'Harga reseller harus berupa angka (tanpa huruf atau simbol).',
            'harga_reseller.min' => 'Harga reseller tidak boleh minus.',
            'stok_saat_ini.required' => 'Stok saat ini wajib diisi.',
            'stok_saat_ini.integer' => 'Stok saat ini harus berupa angka bulat.',
            'stok_saat_ini.min' => 'Stok saat ini tidak boleh minus.',
            'stok_minimum.required' => 'Stok minimum wajib diisi.',
            'stok_minimum.integer' => 'Stok minimum harus berupa angka bulat.',
            'stok_minimum.min' => 'Stok minimum tidak boleh minus.',
            'tanggal_expired.required' => 'Tanggal expired wajib diisi.',
            'tanggal_expired.date' => 'Format tanggal expired tidak valid.',
            'lokasi_penyimpanan.required' => 'Lokasi penyimpanan wajib dipilih.',
            'lokasi_penyimpanan.in' => 'Lokasi penyimpanan tidak valid.',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
