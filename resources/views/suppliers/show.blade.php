@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Supplier</h1>
    <div class="bg-white p-5 rounded shadow space-y-3">
        <div><p class="text-sm text-gray-500">Nama Supplier</p><p class="font-medium">{{ $supplier->nama_supplier }}</p></div>
        <div><p class="text-sm text-gray-500">Nomor Telepon</p><p>{{ $supplier->nomor_telepon ?? '-' }}</p></div>
        <div><p class="text-sm text-gray-500">Produk Dipasok</p><p>{{ $supplier->produk_dipasok ?? '-' }}</p></div>
        <div><p class="text-sm text-gray-500">Termin Pembayaran</p><p class="capitalize">{{ $supplier->termin_pembayaran }}</p></div>
    </div>
    <div class="mt-4 flex gap-3">
        <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ubah</a>
        <a href="{{ route('suppliers.index') }}" class="bg-gray-200 px-4 py-2 rounded">Kembali</a>
    </div>
</div>
@endsection