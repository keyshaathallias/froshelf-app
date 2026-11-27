@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kategori</h1>
        <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">+ Tambah Kategori</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Kategori</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $categories->firstItem() + $i }}</td>
                    <td class="px-4 py-3 font-medium">{{ $cat->nama_kategori }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $cat->deskripsi ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <a href="{{ route('categories.show', $cat) }}" class="text-gray-600 hover:underline">Lihat</a>
                            <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600 hover:underline">Ubah</a>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $categories->links() }}</div>
</div>
@endsection
