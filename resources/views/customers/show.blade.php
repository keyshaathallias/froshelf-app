@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Pelanggan</h1>
    <div class="bg-white p-5 rounded shadow space-y-3">
        <div><p class="text-sm text-gray-500">Nama Pelanggan</p><p class="font-medium">{{ $customer->nama_pelanggan }}</p></div>
        <div><p class="text-sm text-gray-500">Tipe</p><p class="capitalize">{{ $customer->tipe_pelanggan }}</p></div>
        <div><p class="text-sm text-gray-500">Nomor WhatsApp</p><p>{{ $customer->nomor_whatsapp ?? '-' }}</p></div>
        <div><p class="text-sm text-gray-500">Alamat Pengiriman</p><p>{{ $customer->alamat_pengiriman ?? '-' }}</p></div>
    </div>
    <div class="mt-4 flex gap-3">
        <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ubah</a>
        <a href="{{ route('customers.index') }}" class="bg-gray-200 px-4 py-2 rounded">Kembali</a>
    </div>
</div>
@endsection