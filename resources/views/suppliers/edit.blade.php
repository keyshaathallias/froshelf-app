@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Ubah Supplier</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="bg-white p-5 rounded shadow space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block mb-1 font-medium">Nama Supplier <span class="text-red-500">*</span></label>
            <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $supplier->nomor_telepon) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-medium">Produk Dipasok</label>
            <input type="text" name="produk_dipasok" value="{{ old('produk_dipasok', $supplier->produk_dipasok) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-medium">Termin Pembayaran <span class="text-red-500">*</span></label>
            <select name="termin_pembayaran" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="tunai" {{ old('termin_pembayaran', $supplier->termin_pembayaran) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="transfer" {{ old('termin_pembayaran', $supplier->termin_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="tempo" {{ old('termin_pembayaran', $supplier->termin_pembayaran) == 'tempo' ? 'selected' : '' }}>Tempo</option>
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Perbarui</button>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection