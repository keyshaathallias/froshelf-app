@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Pelanggan</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">+ Tambah Pelanggan</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Pelanggan</th>
                    <th class="px-4 py-3 text-left">Tipe</th>
                    <th class="px-4 py-3 text-left">WhatsApp</th>
                    <th class="px-4 py-3 text-left">Alamat</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $i => $cust)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $customers->firstItem() + $i }}</td>
                    <td class="px-4 py-3 font-medium">{{ $cust->nama_pelanggan }}</td>
                    <td class="px-4 py-3 capitalize">
                        <span class="px-2 py-1 text-xs rounded {{ $cust->tipe_pelanggan == 'reseller' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $cust->tipe_pelanggan }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $cust->nomor_whatsapp ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ $cust->alamat_pengiriman ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <a href="{{ route('customers.show', $cust) }}" class="text-gray-600 hover:underline">Lihat</a>
                            <a href="{{ route('customers.edit', $cust) }}" class="text-blue-600 hover:underline">Ubah</a>
                            <form action="{{ route('customers.destroy', $cust) }}" method="POST" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada data pelanggan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $customers->links() }}</div>
</div>
@endsection