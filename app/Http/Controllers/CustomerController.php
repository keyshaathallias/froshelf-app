<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tipe_pelanggan' => 'required|in:umum,reseller',
            // Hanya boleh angka, panjang 10 sampai 15 digit
            'nomor_whatsapp' => ['nullable', 'regex:/^[0-9]{10,15}$/'],
            'alamat_pengiriman' => 'nullable|string',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.string' => 'Nama pelanggan harus berupa teks.',
            'nama_pelanggan.max' => 'Nama pelanggan maksimal 255 karakter.',
            'tipe_pelanggan.required' => 'Tipe pelanggan wajib dipilih.',
            'tipe_pelanggan.in' => 'Tipe pelanggan tidak valid.',
            'nomor_whatsapp.regex' => 'Nomor WhatsApp harus berupa angka (10-15 digit) dan tidak boleh mengandung huruf.',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tipe_pelanggan' => 'required|in:umum,reseller',
            'nomor_whatsapp' => ['nullable', 'regex:/^[0-9]{10,15}$/'],
            'alamat_pengiriman' => 'nullable|string',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.string' => 'Nama pelanggan harus berupa teks.',
            'nama_pelanggan.max' => 'Nama pelanggan maksimal 255 karakter.',
            'tipe_pelanggan.required' => 'Tipe pelanggan wajib dipilih.',
            'tipe_pelanggan.in' => 'Tipe pelanggan tidak valid.',
            'nomor_whatsapp.regex' => 'Nomor WhatsApp harus berupa angka (10-15 digit) dan tidak boleh mengandung huruf.',
        ]);

        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }
}