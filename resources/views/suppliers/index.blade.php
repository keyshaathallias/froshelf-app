@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Supplier</h1>
        <a href="{{ route('suppliers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">+ Tambah Supplier</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Supplier</th>
                    <th class="px-4 py-3 text-left">Telepon</th>
                    <th class="px-4 py-3 text-left">Produk Dipasok</th>
                    <th class="px-4 py-3 text-left">Termin</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $i => $sup)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $suppliers->firstItem() + $i }}</td>
                    <td class="px-4 py-3 font-medium">{{ $sup->nama_supplier }}</td>
                    <td class="px-4 py-3">{{ $sup->nomor_telepon ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $sup->produk_dipasok ?? '-' }}</td>
                    <td class="px-4 py-3 capitalize">{{ $sup->termin_pembayaran }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <a href="{{ route('suppliers.show', $sup) }}" class="text-gray-600 hover:underline">Lihat</a>
                            <a href="{{ route('suppliers.edit', $sup) }}" class="text-blue-600 hover:underline">Ubah</a>
                            <form action="{{ route('suppliers.destroy', $sup) }}" method="POST" onsubmit="return confirm('Yakin hapus supplier ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada data supplier.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $suppliers->links() }}</div>
</div>
@endsection