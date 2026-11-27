<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Halaman Tidak Ditemukan — FroShelf</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-shelly-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-[#F7F8FA] px-4 py-10 text-slate-900 font-sans antialiased">
    <div class="w-full max-w-sm rounded-2xl border border-slate-200/80 bg-white p-7 text-center">
        <img src="{{ asset('images/logo-shelly-icon.png') }}" alt="Logo Shelly Frozen" class="mx-auto mb-3 h-10 w-10 object-contain">
        <p class="text-xs font-semibold tracking-wider text-[#2563EB] uppercase">404 · Tidak Ditemukan</p>
        <h1 class="mt-2 text-lg font-bold tracking-[-0.02em] text-slate-900">Halaman Tidak Ditemukan</h1>
        <p class="mt-2 text-sm leading-relaxed text-slate-500">
            Alamat halaman yang Anda buka tidak tersedia atau mungkin sudah dipindahkan.
        </p>

        <div class="mt-6 flex flex-col gap-2">
            @auth
                <a href="{{ auth()->user()->isPemilik() ? route('dashboard') : route('transactions.index') }}"
                   class="w-full rounded-lg bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#1D4ED8]">
                    Kembali ke Halaman Utama
                </a>
                <a href="{{ route('guidance.index') }}"
                   class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50">
                    Buka Panduan Pakai
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="w-full rounded-lg bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#1D4ED8]">
                    Masuk ke FroShelf
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
