<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk ke FroShelf — UMKM Frozen Shelly</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-shelly-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col justify-center bg-[#F7F8FA] px-4 py-10 text-slate-900 font-sans antialiased">
    <main class="mx-auto w-full max-w-[400px]">
        {{-- Minimal Brand Header --}}
        <div class="mb-7 text-center">
            <img src="{{ asset('images/logo-shelly-frozen.png') }}"
                 alt="Logo Shelly Frozen"
                 class="mx-auto h-20 w-auto object-contain">
            <h1 class="mt-4 text-xl font-bold tracking-[-0.02em] text-slate-900">Masuk ke FroShelf</h1>
            <p class="mt-1 text-sm text-slate-500">UMKM Frozen Shelly · Sistem Kasir &amp; Stok Freezer</p>
        </div>

        {{-- Clean Single-Column Card --}}
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-[0_1px_2px_rgba(15,23,42,0.04)] sm:p-7">
            @if (session('success'))
                <div role="status" class="mb-5 flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50/70 px-3.5 py-2.5 text-xs font-medium text-blue-900">
                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-[#2563EB]"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-3.5 py-2.5 text-xs text-rose-800">
                    <p class="font-semibold">Tidak dapat masuk:</p>
                    <ul class="mt-1 list-disc space-y-0.5 pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4" novalidate>
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700">Email</label>
                    <input id="email"
                           name="email"
                           type="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus
                           placeholder="nama@froshelf.test"
                           class="mt-1.5 block w-full rounded-lg border {{ $errors->has('email') ? 'border-rose-400' : 'border-slate-300/90' }} bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-colors focus:border-[#2563EB] focus:ring-2 focus:ring-blue-600/15 focus:outline-none">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                    <div class="relative mt-1.5">
                        <input id="password"
                               name="password"
                               type="password"
                               required
                               autocomplete="current-password"
                               placeholder="Masukkan kata sandi"
                               class="block w-full rounded-lg border {{ $errors->has('password') ? 'border-rose-400' : 'border-slate-300/90' }} bg-white py-2.5 pr-10 pl-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition-colors focus:border-[#2563EB] focus:ring-2 focus:ring-blue-600/15 focus:outline-none">
                        <button type="button"
                                data-toggle-password="password"
                                aria-label="Lihat kata sandi"
                                aria-pressed="false"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-700">
                            <svg data-eye-open class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg data-eye-closed class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <label for="remember" class="inline-flex cursor-pointer items-center gap-2 pt-0.5 text-xs text-slate-600 select-none">
                    <input id="remember"
                           name="remember"
                           type="checkbox"
                           value="1"
                           {{ old('remember') ? 'checked' : '' }}
                           class="h-3.5 w-3.5 rounded border-slate-300 text-[#2563EB] focus:ring-blue-600">
                    <span>Ingat saya di perangkat ini</span>
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white transition-colors duration-150 hover:bg-[#1D4ED8] focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:outline-none">
                    Masuk ke Sistem
                </button>
            </form>

            {{-- Subtle Quick-Fill Demo Accounts Strip --}}
            <div class="mt-6 border-t border-slate-100 pt-5">
                <div class="flex items-center justify-between text-[11px] text-slate-500">
                    <span class="font-medium">Akun demo (klik untuk isi cepat)</span>
                    <span class="font-mono text-slate-400">sandi: password</span>
                </div>

                <div class="mt-2.5 grid grid-cols-2 gap-2">
                    <button type="button"
                            data-demo-email="pemilik@froshelf.test"
                            data-demo-password="password"
                            class="rounded-lg border border-slate-200 bg-slate-50/70 px-3 py-2 text-left transition-colors hover:border-slate-300 hover:bg-slate-100/70">
                        <span class="block text-xs font-semibold text-slate-900">Pemilik</span>
                        <span class="block truncate text-[11px] text-slate-500">pemilik@froshelf.test</span>
                    </button>

                    <button type="button"
                            data-demo-email="staf@froshelf.test"
                            data-demo-password="password"
                            class="rounded-lg border border-slate-200 bg-slate-50/70 px-3 py-2 text-left transition-colors hover:border-slate-300 hover:bg-slate-100/70">
                        <span class="block text-xs font-semibold text-slate-900">Staf Kasir</span>
                        <span class="block truncate text-[11px] text-slate-500">staf@froshelf.test</span>
                    </button>
                </div>
            </div>
        </div>

        <p class="mt-5 text-center text-xs text-slate-500">
            Lupa cara pakai sistem? Panduan lengkap tersedia di dalam aplikasi.
        </p>
    </main>
</body>
</html>
