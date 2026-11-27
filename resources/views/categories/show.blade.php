@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Kategori</h1>
    <div class="bg-white p-5 rounded shadow space-y-3">
        <div><p class="text-sm text-gray-500">Nama Kategori</p><p class="font-medium">{{ $category->nama_kategori }}</p></div>
        <div><p class="text-sm text-gray-500">Deskripsi</p><p>{{ $category->deskripsi ?? '-' }}</p></div>
        <div><p class="text-sm text-gray-500">Dibuat</p><p>{{ $category->created_at->format('d M Y H:i') }}</p></div>
    </div>
    <div class="mt-4 flex gap-3">
        <a href="{{ route('categories.edit', $category) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ubah</a>
        <a href="{{ route('categories.index') }}" class="bg-gray-200 px-4 py-2 rounded">Kembali</a>
    </div>
</div>
@endsection
