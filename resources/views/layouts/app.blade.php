@php
    $user = auth()->user();
    $isPemilik = $user && $user->isPemilik();

    $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulanIndo = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
        7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
    ];
    $now = now();
    $tanggalHariIni = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;

    $utamaNav = [];
    if ($isPemilik) {
        $utamaNav[] = ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard'), 'icon' => 'dashboard'];
    }
    $utamaNav[] = ['label' => 'Kasir & Transaksi', 'route' => 'transactions.index', 'active' => request()->routeIs('transactions.*'), 'icon' => 'transactions'];
    $utamaNav[] = ['label' => 'Produk & Stok', 'route' => 'products.index', 'active' => request()->routeIs('products.*'), 'icon' => 'products'];

    $dataTokoNav = [];
    if ($isPemilik) {
        $dataTokoNav = [
            ['label' => 'Kategori', 'route' => 'categories.index', 'active' => request()->routeIs('categories.*'), 'icon' => 'categories'],
            ['label' => 'Supplier', 'route' => 'suppliers.index', 'active' => request()->routeIs('suppliers.*'), 'icon' => 'suppliers'],
            ['label' => 'Pelanggan', 'route' => 'customers.index', 'active' => request()->routeIs('customers.*'), 'icon' => 'customers'],
            ['label' => 'Rekap Laporan', 'route' => 'reports.index', 'active' => request()->routeIs('reports.*'), 'icon' => 'reports'],
        ];
    }

    $homeRoute = $isPemilik ? route('dashboard') : route('transactions.index');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FroShelf') — FroShelf</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-shelly-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F7F8FA] text-slate-900 font-sans antialiased">
    {{-- Desktop Fixed Left Sidebar (236px) --}}
    <aside class="fixed inset-y-0 left-0 z-30 hidden w-[236px] flex-col border-r border-slate-200/80 bg-white lg:flex"
           aria-label="Navigasi utama">
        {{-- Brand Header --}}
        <div class="flex h-14 items-center px-5 border-b border-slate-100">
            <a href="{{ $homeRoute }}" class="flex items-center gap-2.5 focus:outline-none">
                <img src="{{ asset('images/logo-shelly-icon.png') }}"
                     alt="Logo Shelly Frozen"
                     class="h-8 w-8 shrink-0 object-contain">
                <div class="leading-none">
                    <span class="block text-[15px] font-bold tracking-[-0.02em] text-slate-900">FroShelf</span>
                    <span class="mt-0.5 block text-[11px] font-medium text-slate-400">Shelly Frozen</span>
                </div>
            </a>
        </div>

        {{-- Grouped Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5" aria-label="Menu aplikasi">
            {{-- Group 1: Utama --}}
            <div>
                <p class="px-2.5 pb-1.5 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Utama</p>
                <div class="space-y-0.5">
                    @foreach ($utamaNav as $item)
                        <a href="{{ route($item['route']) }}"
                           @if($item['active']) aria-current="page" @endif
                           class="group relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13.5px] font-medium transition-colors duration-150 {{ $item['active'] ? 'bg-blue-50/90 text-[#2563EB] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            @if ($item['active'])
                                <span class="absolute top-1.5 bottom-1.5 left-0 w-[3px] rounded-r-full bg-[#2563EB]" aria-hidden="true"></span>
                            @endif
                            @switch($item['icon'])
                                @case('dashboard')
                                    <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                                    </svg>
                                    @break
                                @case('transactions')
                                    <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2Z" />
                                    </svg>
                                    @break
                                @case('products')
                                    <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 8-9-5-9 5m18 0-9 5m9-5v8l-9 5m0-8L3 8m9 5v8m-9-13v8l9 5" />
                                    </svg>
                                    @break
                            @endswitch
                            <span class="truncate">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Group 2: Data Toko (Pemilik only) --}}
            @if (! empty($dataTokoNav))
                <div>
                    <p class="px-2.5 pb-1.5 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Data Toko</p>
                    <div class="space-y-0.5">
                        @foreach ($dataTokoNav as $item)
                            <a href="{{ route($item['route']) }}"
                               @if($item['active']) aria-current="page" @endif
                               class="group relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13.5px] font-medium transition-colors duration-150 {{ $item['active'] ? 'bg-blue-50/90 text-[#2563EB] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                @if ($item['active'])
                                    <span class="absolute top-1.5 bottom-1.5 left-0 w-[3px] rounded-r-full bg-[#2563EB]" aria-hidden="true"></span>
                                @endif
                                @switch($item['icon'])
                                    @case('categories')
                                        <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a1.99 1.99 0 0 1 1.414.586l7 7a2 2 0 0 1 0 2.828l-7 7a2 2 0 0 1-2.828 0l-7-7A1.994 1.994 0 0 1 3 12V7a4 4 0 0 1 4-4Z" />
                                        </svg>
                                        @break
                                    @case('suppliers')
                                        <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11v10H3V7Zm11 3h4l3 3v4h-7v-7Z" />
                                            <circle cx="7.5" cy="17.5" r="1.5" />
                                            <circle cx="17.5" cy="17.5" r="1.5" />
                                        </svg>
                                        @break
                                    @case('customers')
                                        <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 0 1 5.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 0 1 9.288 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        @break
                                    @case('reports')
                                        <svg class="h-[18px] w-[18px] shrink-0 {{ $item['active'] ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                                        </svg>
                                        @break
                                @endswitch
                                <span class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Group 3: Bantuan --}}
            <div>
                <p class="px-2.5 pb-1.5 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Bantuan</p>
                <a href="{{ route('guidance.index') }}"
                   @if(request()->routeIs('guidance.*')) aria-current="page" @endif
                   class="group relative flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-[13.5px] font-medium transition-colors duration-150 {{ request()->routeIs('guidance.*') ? 'bg-blue-50/90 text-[#2563EB] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    @if (request()->routeIs('guidance.*'))
                        <span class="absolute top-1.5 bottom-1.5 left-0 w-[3px] rounded-r-full bg-[#2563EB]" aria-hidden="true"></span>
                    @endif
                    <svg class="h-[18px] w-[18px] shrink-0 {{ request()->routeIs('guidance.*') ? 'text-[#2563EB]' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Panduan Pakai</span>
                </a>
            </div>
        </nav>

        {{-- Compact Account Footer --}}
        @if ($user)
            <div class="border-t border-slate-100 p-3">
                <div class="flex items-center justify-between gap-2 rounded-lg px-2 py-1.5">
                    <div class="flex min-w-0 items-center gap-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </span>
                        <div class="min-w-0 leading-tight">
                            <p class="truncate text-xs font-semibold text-slate-900">{{ $user->name }}</p>
                            <p class="truncate text-[11px] text-slate-500">{{ $user->roleLabel() }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                title="Keluar dari FroShelf"
                                aria-label="Keluar"
                                class="rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-rose-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </aside>

    {{-- Main Content Shell --}}
    <div class="flex min-h-screen flex-col lg:pl-[236px]">
        {{-- Minimal Top Bar (56px) --}}
        <header class="sticky top-0 z-20 flex h-14 items-center justify-between gap-3 border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-sm sm:px-6">
            <div class="flex min-w-0 items-center gap-2.5">
                {{-- Brand mark visible on mobile only --}}
                <a href="{{ $homeRoute }}" class="flex h-8 w-8 shrink-0 items-center justify-center lg:hidden" aria-label="FroShelf">
                    <img src="{{ asset('images/logo-shelly-icon.png') }}"
                         alt="Logo Shelly Frozen"
                         class="h-7 w-7 object-contain">
                </a>
                <p class="truncate text-sm font-semibold text-slate-900">
                    @yield('page_title', 'FroShelf')
                </p>
            </div>

            <div class="flex shrink-0 items-center gap-3">
                <span class="hidden text-xs font-medium text-slate-500 md:inline">
                    {{ $tanggalHariIni }}
                </span>

                <span class="hidden h-4 w-px bg-slate-200 md:inline-block" aria-hidden="true"></span>

                {{-- Clean Ghost Help Button (FR-00A) --}}
                <button type="button"
                        data-open-guidance
                        aria-expanded="false"
                        aria-controls="guidance-drawer"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-medium text-slate-700 transition-colors hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
                    <svg class="h-3.5 w-3.5 text-[#2563EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3M12 17h.01" />
                    </svg>
                    <span class="hidden sm:inline">Panduan Cara Pakai</span>
                    <span class="sm:hidden">Panduan</span>
                </button>
            </div>
        </header>

        {{-- Main Workspace --}}
        <main class="flex-1 px-4 pt-5 pb-24 sm:px-6 sm:pt-6 lg:pb-10">
            <div class="mx-auto max-w-6xl space-y-6">
                @if (session('success'))
                    <div data-dismissible
                         role="status"
                         class="flex items-center justify-between gap-3 rounded-xl border border-blue-200 bg-blue-50/70 px-4 py-2.5 text-sm text-blue-900">
                        <div class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-[#2563EB]"></span>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button type="button" data-dismiss class="rounded p-1 text-blue-700 hover:bg-blue-100/70" aria-label="Tutup pesan">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div data-dismissible
                         role="alert"
                         class="flex items-center justify-between gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm text-rose-900">
                        <div class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-rose-600"></span>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button type="button" data-dismiss class="rounded p-1 text-rose-700 hover:bg-rose-100" aria-label="Tutup pesan">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    {{-- Mobile Bottom Navigation Bar (1-thumb easy navigation untuk 360px+) --}}
    <nav class="fixed inset-x-0 bottom-0 z-30 border-t border-slate-200 bg-white/95 backdrop-blur-sm lg:hidden"
         aria-label="Navigasi bawah mobile">
        <div class="grid h-16 grid-cols-4">
            @if ($isPemilik)
                <a href="{{ route('dashboard') }}"
                   class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium {{ request()->routeIs('dashboard') ? 'text-[#2563EB] font-semibold' : 'text-slate-500' }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('transactions.index') }}"
                   class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium {{ request()->routeIs('transactions.*') ? 'text-[#2563EB] font-semibold' : 'text-slate-500' }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2Z" />
                    </svg>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('products.index') }}"
                   class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium {{ request()->routeIs('products.*') ? 'text-[#2563EB] font-semibold' : 'text-slate-500' }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 8-9-5-9 5m18 0-9 5m9-5v8l-9 5m0-8L3 8m9 5v8m-9-13v8l9 5" />
                    </svg>
                    <span>Produk</span>
                </a>
            @else
                <a href="{{ route('transactions.index') }}"
                   class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium {{ request()->routeIs('transactions.*') ? 'text-[#2563EB] font-semibold' : 'text-slate-500' }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2Z" />
                    </svg>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('products.index') }}"
                   class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium {{ request()->routeIs('products.*') ? 'text-[#2563EB] font-semibold' : 'text-slate-500' }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 8-9-5-9 5m18 0-9 5m9-5v8l-9 5m0-8L3 8m9 5v8m-9-13v8l9 5" />
                    </svg>
                    <span>Produk</span>
                </a>
                <a href="{{ route('guidance.index') }}"
                   class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium {{ request()->routeIs('guidance.*') ? 'text-[#2563EB] font-semibold' : 'text-slate-500' }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Panduan</span>
                </a>
            @endif

            <button type="button"
                    data-open-mobile-sheet
                    aria-expanded="false"
                    aria-controls="mobile-menu-sheet"
                    class="flex flex-col items-center justify-center gap-1 text-[11px] font-medium text-slate-500 hover:text-slate-900">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>{{ $isPemilik ? 'Lainnya' : 'Akun' }}</span>
            </button>
        </div>
    </nav>

    {{-- Mobile Bottom Sheet (Menu Lainnya & Akun) --}}
    <div id="mobile-menu-backdrop"
         class="fixed inset-0 z-40 hidden bg-slate-900/35 lg:hidden"
         aria-hidden="true"></div>

    <div id="mobile-menu-sheet"
         class="fixed inset-x-0 bottom-0 z-50 translate-y-full rounded-t-2xl border-t border-slate-200 bg-white px-4 pt-3 pb-6 shadow-xl transition-transform duration-200 ease-out lg:hidden"
         aria-hidden="true"
         aria-label="Menu lainnya">
        <div class="mx-auto mb-3 h-1 w-10 rounded-full bg-slate-200" aria-hidden="true"></div>

        @if ($user)
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </span>
                    <div class="leading-tight">
                        <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->roleLabel() }} · {{ $tanggalHariIni }}</p>
                    </div>
                </div>
                <button type="button" data-close-mobile-sheet class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup menu">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if ($isPemilik)
            <div class="mt-3 grid grid-cols-2 gap-2">
                @foreach ($dataTokoNav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="rounded-xl border border-slate-200/80 px-3 py-2.5 text-sm font-medium {{ $item['active'] ? 'border-blue-300 bg-blue-50/70 text-[#2563EB]' : 'text-slate-700 hover:bg-slate-50' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('guidance.index') }}"
                   class="col-span-2 rounded-xl border border-slate-200/80 px-3 py-2.5 text-sm font-medium {{ request()->routeIs('guidance.*') ? 'border-blue-300 bg-blue-50/70 text-[#2563EB]' : 'text-slate-700 hover:bg-slate-50' }}">
                    Panduan Pakai
                </a>
            </div>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit"
                    class="w-full rounded-xl border border-rose-200 bg-rose-50/60 px-4 py-2.5 text-sm font-semibold text-rose-700 hover:bg-rose-100/70">
                Keluar dari FroShelf
            </button>
        </form>
    </div>

    {{-- Contextual Slide-Over Guidance Drawer (FR-00C) --}}
    @include('partials.guidance-drawer')
</body>
</html>
