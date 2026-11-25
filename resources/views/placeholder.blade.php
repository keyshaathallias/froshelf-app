@extends('layouts.app')

@section('title', $meta['title'])
@section('page_title', $meta['title'])

@section('content')
    <div class="rounded-xl border border-slate-200/80 bg-white p-6 sm:p-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-medium text-slate-500">
                    Modul {{ $meta['code'] }} · PIC {{ $meta['owner'] }} · Menunggu integrasi branch
                </p>
                <h1 class="mt-1.5 text-xl font-bold tracking-[-0.02em] text-slate-900">
                    {{ $meta['title'] }}
                </h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    {{ $meta['description'] }}
                </p>
            </div>

            <div class="flex shrink-0 flex-wrap gap-2">
                <a href="{{ route('guidance.index') }}"
                   class="inline-flex items-center rounded-lg bg-[#2563EB] px-3.5 py-2 text-xs font-semibold text-white transition-colors hover:bg-[#1D4ED8]">
                    Buka Panduan Pakai
                </a>
                @if (auth()->user()?->isPemilik())
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
                        Kembali ke Dashboard
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-6 border-t border-slate-100 pt-5">
            <h2 class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Alur Singkat Halaman Ini</h2>
            <ul class="mt-3 space-y-2 text-sm text-slate-600">
                @foreach ($meta['tips'] as $tip)
                    <li class="flex items-start gap-2.5">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#2563EB]"></span>
                        <span>{{ $tip }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
