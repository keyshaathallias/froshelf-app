@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    {{-- Calm Header Row + Segmented Period Switcher --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-[-0.02em] text-slate-900 sm:text-2xl">
                Halo, {{ auth()->user()->name }}!
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Ringkasan penjualan dan kondisi stok Frozen Shelly · {{ $rangeLabel }}.
            </p>
        </div>

        {{-- Clean Segmented Period Control --}}
        <div class="inline-flex self-start rounded-lg border border-slate-200/80 bg-slate-100/70 p-0.5 text-xs font-medium sm:self-auto" role="group" aria-label="Filter periode">
            @foreach ([
                'hari_ini' => 'Hari Ini',
                '7_hari' => '7 Hari',
                'bulan_ini' => 'Bulan Ini',
            ] as $key => $label)
                <a href="{{ route('dashboard', ['periode' => $key]) }}"
                   class="rounded-md px-3 py-1.5 transition-colors {{ $period === $key ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Quiet 1-line Integration Note if teammate tables are not yet migrated --}}
    @if (! $hasProducts || ! $hasTransactions)
        <p class="flex items-center gap-2 text-xs text-slate-500">
            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-blue-600"></span>
            <span>
                Angka akan terisi otomatis setelah tabel
                @if (! $hasProducts && ! $hasTransactions)
                    <code class="font-mono text-slate-700">products</code> (Vany) &amp; <code class="font-mono text-slate-700">transactions</code> (Kevin)
                @elseif (! $hasProducts)
                    <code class="font-mono text-slate-700">products</code> (Vany)
                @else
                    <code class="font-mono text-slate-700">transactions</code> (Kevin)
                @endif
                digabungkan.
            </span>
        </p>
    @endif

    {{-- 4 Uniform Flat KPI Cards --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan metrik utama">
        {{-- Omzet --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Omzet {{ $rangeLabel }}</span>
                @if ($omzetChangePercent !== null)
                    <span class="text-xs font-semibold tabular-nums {{ $omzetChangePercent >= 0 ? 'text-[#2563EB]' : 'text-rose-600' }}">
                        {{ $omzetChangePercent >= 0 ? '+' : '' }}{{ $omzetChangePercent }}%
                    </span>
                @endif
            </div>
            <p class="mt-2.5 text-2xl font-bold tracking-[-0.02em] text-slate-900 tabular-nums">
                Rp {{ number_format($omzetPeriode, 0, ',', '.') }}
            </p>
            <p class="mt-1.5 text-xs text-slate-500">Total penjualan toko &amp; WhatsApp</p>
        </div>

        {{-- Total Transaksi --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5">
            <span class="text-xs font-medium text-slate-500">Total Transaksi</span>
            <p class="mt-2.5 text-2xl font-bold tracking-[-0.02em] text-slate-900 tabular-nums">
                {{ number_format($totalTransaksi, 0, ',', '.') }}
            </p>
            <p class="mt-1.5 text-xs text-slate-500">
                {{ $transaksiToko }} di toko · {{ $transaksiWa }} via WhatsApp
            </p>
        </div>

        {{-- Pesanan WA Aktif --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Pesanan WA Aktif</span>
                @if ($pesananWaAktif > 0)
                    <span class="h-2 w-2 rounded-full bg-amber-500" aria-hidden="true"></span>
                @endif
            </div>
            <p class="mt-2.5 text-2xl font-bold tracking-[-0.02em] text-slate-900 tabular-nums">
                {{ number_format($pesananWaAktif, 0, ',', '.') }}
            </p>
            <p class="mt-1.5 text-xs text-slate-500">Menunggu diproses / siap dikirim</p>
        </div>

        {{-- Peringatan Stok & Expired --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Perlu Perhatian</span>
                @if ($totalAlerts > 0)
                    <span class="h-2 w-2 rounded-full bg-rose-500" aria-hidden="true"></span>
                @endif
            </div>
            <p class="mt-2.5 text-2xl font-bold tracking-[-0.02em] text-slate-900 tabular-nums">
                {{ number_format($totalAlerts, 0, ',', '.') }} <span class="text-sm font-medium text-slate-400">/ {{ $totalProduk }} SKU</span>
            </p>
            <p class="mt-1.5 text-xs text-slate-500">
                {{ $lowStockProducts->count() }} stok menipis · {{ $expiringProducts->count() }} dekat expired
            </p>
        </div>
    </section>

    {{-- Middle Row: 7-Day Revenue Bar Chart + Category Breakdown --}}
    <section class="grid grid-cols-1 gap-4 lg:grid-cols-12">
        {{-- Left: Grafik Omzet 7 Hari Terakhir --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5 lg:col-span-8">
            <div class="flex items-baseline justify-between gap-2">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Omzet 7 Hari Terakhir</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Pergerakan total penjualan harian</p>
                </div>
                <span class="text-xs font-medium text-slate-400">Harian</span>
            </div>

            <div class="mt-6 flex h-48 items-end justify-between gap-2 border-b border-slate-100 pb-3 sm:gap-4">
                @foreach ($dailyRevenue as $day)
                    @php
                        $heightPercent = $day['total'] > 0 ? max(8, (int) round(($day['total'] / $maxDailyRevenue) * 100)) : 3;
                    @endphp
                    <div class="group flex h-full flex-1 flex-col items-center justify-end gap-2">
                        <span class="hidden text-[11px] font-medium text-slate-400 tabular-nums sm:block">
                            {{ $day['total'] > 0 ? number_format($day['total'] / 1000, 0, ',', '.').'rb' : '0' }}
                        </span>
                        <div class="flex w-full max-w-[36px] flex-1 items-end">
                            <div class="w-full rounded-t-md transition-colors duration-150 {{ $day['total'] > 0 ? 'bg-[#2563EB] group-hover:bg-[#1D4ED8]' : 'bg-slate-100' }}"
                                 style="height: {{ $heightPercent }}%"
                                 title="{{ $day['label'] }} ({{ $day['date'] }}): Rp {{ number_format($day['total'], 0, ',', '.') }}">
                            </div>
                        </div>
                        <div class="text-center leading-tight">
                            <span class="block text-xs font-medium text-slate-700">{{ $day['label'] }}</span>
                            <span class="block text-[10px] text-slate-400">{{ $day['date'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right: Penjualan per Kategori --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5 lg:col-span-4">
            <h2 class="text-sm font-semibold text-slate-900">Penjualan per Kategori</h2>
            <p class="mt-0.5 text-xs text-slate-500">Kontribusi omzet ({{ strtolower($rangeLabel) }})</p>

            @if ($categorySales->isNotEmpty())
                <div class="mt-5 space-y-4">
                    @foreach ($categorySales as $cat)
                        @php
                            $pct = (int) round(($cat->total_omzet / $totalCategoryRevenue) * 100);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between gap-2 text-xs">
                                <span class="truncate font-medium text-slate-700">{{ $cat->nama_kategori }}</span>
                                <span class="shrink-0 font-semibold text-slate-900 tabular-nums">{{ $pct }}%</span>
                            </div>
                            <div class="mt-1.5 h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-[#2563EB]" style="width: {{ max(4, $pct) }}%"></div>
                            </div>
                            <p class="mt-1 text-[11px] text-slate-400 tabular-nums">
                                Rp {{ number_format($cat->total_omzet, 0, ',', '.') }} · {{ $cat->total_qty }} terjual
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-10 text-center">
                    <p class="text-xs font-medium text-slate-500">Belum ada penjualan kategori</p>
                    <p class="mt-1 text-xs text-slate-400">Muncul otomatis saat transaksi masuk.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Bottom Row: Warning Tables --}}
    <section class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        {{-- Peringatan Stok Menipis --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-500" aria-hidden="true"></span>
                    <h2 class="text-sm font-semibold text-slate-900">Peringatan Stok Menipis</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs font-medium text-[#2563EB] hover:text-blue-800">
                    Lihat semua →
                </a>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] font-medium text-slate-400 uppercase">
                            <th class="pb-2.5 pr-3">Produk</th>
                            <th class="pb-2.5 pr-3">Lokasi</th>
                            <th class="pb-2.5 text-right">Sisa / Min</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs sm:text-[13px]">
                        @forelse ($lowStockProducts as $item)
                            @php
                                $dotColor = match ($item->lokasi_penyimpanan) {
                                    'Freezer 1' => 'bg-sky-500',
                                    'Freezer 2' => 'bg-teal-500',
                                    default => 'bg-amber-500',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 pr-3 font-medium text-slate-800">{{ $item->nama_produk }}</td>
                                <td class="py-3 pr-3 text-slate-600">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $dotColor }}"></span>
                                        {{ $item->lokasi_penyimpanan }}
                                    </span>
                                </td>
                                <td class="py-3 text-right font-semibold tabular-nums text-amber-700">
                                    {{ $item->stok_saat_ini }} / {{ $item->stok_minimum }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-xs text-slate-400">
                                    {{ $hasProducts ? 'Semua stok berada di atas batas minimum.' : 'Menunggu data produk dari modul F-03.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Produk Mendekati Expired --}}
        <div class="rounded-xl border border-slate-200/80 bg-white p-5">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-rose-500" aria-hidden="true"></span>
                    <h2 class="text-sm font-semibold text-slate-900">Produk Mendekati Expired</h2>
                </div>
                <span class="text-xs font-medium text-slate-400">≤ 30 hari</span>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] font-medium text-slate-400 uppercase">
                            <th class="pb-2.5 pr-3">Produk</th>
                            <th class="pb-2.5 pr-3">Tgl Expired</th>
                            <th class="pb-2.5 text-right">Sisa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs sm:text-[13px]">
                        @forelse ($expiringProducts as $item)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 pr-3">
                                    <span class="block font-medium text-slate-800">{{ $item->nama_produk }}</span>
                                    <span class="block text-[11px] text-slate-400">{{ $item->kode_sku }}</span>
                                </td>
                                <td class="py-3 pr-3 font-medium text-rose-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal_expired)->format('d M Y') }}
                                </td>
                                <td class="py-3 text-right font-medium tabular-nums text-slate-700">
                                    {{ $item->stok_saat_ini }} pcs
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-xs text-slate-400">
                                    {{ $hasProducts ? 'Tidak ada produk mendekati expired dalam 30 hari.' : 'Menunggu data produk dari modul F-03.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
