<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            // Hanya boleh angka, panjang 10 sampai 15 digit
            'nomor_telepon' => ['nullable', 'regex:/^[0-9]{10,15}$/'],
            'produk_dipasok' => 'nullable|string',
            'termin_pembayaran' => 'required|in:tunai,transfer,tempo',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.string' => 'Nama supplier harus berupa teks.',
            'nama_supplier.max' => 'Nama supplier maksimal 255 karakter.',
            'nomor_telepon.regex' => 'Nomor telepon harus berupa angka (10-15 digit) dan tidak boleh mengandung huruf.',
            'termin_pembayaran.required' => 'Termin pembayaran wajib dipilih.',
            'termin_pembayaran.in' => 'Termin pembayaran tidak valid.',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'nomor_telepon' => ['nullable', 'regex:/^[0-9]{10,15}$/'],
            'produk_dipasok' => 'nullable|string',
            'termin_pembayaran' => 'required|in:tunai,transfer,tempo',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.string' => 'Nama supplier harus berupa teks.',
            'nama_supplier.max' => 'Nama supplier maksimal 255 karakter.',
            'nomor_telepon.regex' => 'Nomor telepon harus berupa angka (10-15 digit) dan tidak boleh mengandung huruf.',
            'termin_pembayaran.required' => 'Termin pembayaran wajib dipilih.',
            'termin_pembayaran.in' => 'Termin pembayaran tidak valid.',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}