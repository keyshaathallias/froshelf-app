@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Produk</h1>
    <div class="bg-white p-5 rounded shadow space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><p class="text-sm text-gray-500">Kode SKU</p><p class="font-mono font-medium">{{ $product->kode_sku }}</p></div>
            <div><p class="text-sm text-gray-500">Kategori</p><p class="font-medium">{{ $product->category->nama_kategori ?? '-' }}</p></div>
        </div>
        <div><p class="text-sm text-gray-500">Nama Produk</p><p class="font-medium">{{ $product->nama_produk }}</p></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
            <div><p class="text-sm text-gray-500">Harga Normal</p><p>Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</p></div>
            <div><p class="text-sm text-gray-500">Harga Reseller</p><p>Rp {{ number_format($product->harga_reseller, 0, ',', '.') }}</p></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
            <div><p class="text-sm text-gray-500">Stok Saat Ini</p><p>{{ $product->stok_saat_ini }}</p></div>
            <div><p class="text-sm text-gray-500">Stok Minimum</p><p>{{ $product->stok_minimum }}</p></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
            <div><p class="text-sm text-gray-500">Tanggal Expired</p><p>{{ \Carbon\Carbon::parse($product->tanggal_expired)->format('d M Y') }}</p></div>
            <div><p class="text-sm text-gray-500">Lokasi Penyimpanan</p><p>{{ $product->lokasi_penyimpanan }}</p></div>
        </div>
    </div>
    <div class="mt-4 flex gap-3">
        <a href="{{ route('products.edit', $product) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ubah</a>
        <a href="{{ route('products.index') }}" class="bg-gray-200 px-4 py-2 rounded">Kembali</a>
    </div>
</div>
@endsection