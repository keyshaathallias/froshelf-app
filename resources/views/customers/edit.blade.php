@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Ubah Pelanggan</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('customers.update', $customer) }}" method="POST" class="bg-white p-5 rounded shadow space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block mb-1 font-medium">Nama Pelanggan <span class="text-red-500">*</span></label>
            <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $customer->nama_pelanggan) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Tipe Pelanggan <span class="text-red-500">*</span></label>
            <select name="tipe_pelanggan" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="umum" {{ old('tipe_pelanggan', $customer->tipe_pelanggan) == 'umum' ? 'selected' : '' }}>Umum</option>
                <option value="reseller" {{ old('tipe_pelanggan', $customer->tipe_pelanggan) == 'reseller' ? 'selected' : '' }}>Reseller</option>
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Nomor WhatsApp</label>
            <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp', $customer->nomor_whatsapp) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-medium">Alamat Pengiriman</label>
            <textarea name="alamat_pengiriman" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('alamat_pengiriman', $customer->alamat_pengiriman) }}</textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Perbarui</button>
            <a href="{{ route('customers.index') }}" class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection