@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Produk</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">+ Tambah Produk</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">SKU</th>
                    <th class="px-4 py-3 text-left">Nama Produk</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga Normal</th>
                    <th class="px-4 py-3 text-left">Harga Reseller</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-left">Lokasi</th>
                    <th class="px-4 py-3 text-left">Expired</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $prod->kode_sku }}</td>
                    <td class="px-4 py-3 font-medium">{{ $prod->nama_produk }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $prod->category->nama_kategori ?? '-' }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($prod->harga_normal, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($prod->harga_reseller, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded {{ $prod->stok_saat_ini <= $prod->stok_minimum ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $prod->stok_saat_ini }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $prod->lokasi_penyimpanan }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($prod->tanggal_expired)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <a href="{{ route('products.show', $prod) }}" class="text-gray-600 hover:underline">Lihat</a>
                            <a href="{{ route('products.edit', $prod) }}" class="text-blue-600 hover:underline">Ubah</a>
                            <form action="{{ route('products.destroy', $prod) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-4 py-6 text-center text-gray-500">Belum ada data produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection