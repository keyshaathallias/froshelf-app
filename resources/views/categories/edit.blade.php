@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Ubah Kategori</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white p-5 rounded shadow space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block mb-1 font-medium">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('deskripsi', $category->deskripsi) }}</textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Perbarui</button>
            <a href="{{ route('categories.index') }}" class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
