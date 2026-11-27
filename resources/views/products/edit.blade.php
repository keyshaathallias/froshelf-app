@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Ubah Produk</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('products.update', $product) }}" method="POST" class="bg-white p-5 rounded shadow space-y-4">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Kode SKU <span class="text-red-500">*</span></label>
                <input type="text" name="kode_sku" value="{{ old('kode_sku', $product->kode_sku) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-medium">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Harga Normal <span class="text-red-500">*</span></label>
                <input type="number" name="harga_normal" value="{{ old('harga_normal', $product->harga_normal) }}" class="w-full border border-gray-300 rounded px-3 py-2" required min="0">
            </div>
            <div>
                <label class="block mb-1 font-medium">Harga Reseller <span class="text-red-500">*</span></label>
                <input type="number" name="harga_reseller" value="{{ old('harga_reseller', $product->harga_reseller) }}" class="w-full border border-gray-300 rounded px-3 py-2" required min="0">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Stok Saat Ini <span class="text-red-500">*</span></label>
                <input type="number" name="stok_saat_ini" value="{{ old('stok_saat_ini', $product->stok_saat_ini) }}" class="w-full border border-gray-300 rounded px-3 py-2" required min="0">
            </div>
            <div>
                <label class="block mb-1 font-medium">Stok Minimum <span class="text-red-500">*</span></label>
                <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $product->stok_minimum) }}" class="w-full border border-gray-300 rounded px-3 py-2" required min="0">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Tanggal Expired <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_expired" value="{{ old('tanggal_expired', $product->tanggal_expired) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-medium">Lokasi Penyimpanan <span class="text-red-500">*</span></label>
                <select name="lokasi_penyimpanan" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="Freezer 1" {{ old('lokasi_penyimpanan', $product->lokasi_penyimpanan) == 'Freezer 1' ? 'selected' : '' }}>Freezer 1</option>
                    <option value="Freezer 2" {{ old('lokasi_penyimpanan', $product->lokasi_penyimpanan) == 'Freezer 2' ? 'selected' : '' }}>Freezer 2</option>
                    <option value="Gudang Kering" {{ old('lokasi_penyimpanan', $product->lokasi_penyimpanan) == 'Gudang Kering' ? 'selected' : '' }}>Gudang Kering</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Perbarui</button>
            <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection