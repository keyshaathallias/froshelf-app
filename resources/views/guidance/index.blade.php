@extends('layouts.app')

@section('title', 'Panduan Pakai')
@section('page_title', 'Panduan Pakai')

@section('content')
    {{-- Calm Help-Center Header + Segmented Role Switcher --}}
    <section class="flex flex-col gap-4 border-b border-slate-200/80 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="max-w-xl">
            <h1 class="text-xl font-bold tracking-[-0.02em] text-slate-900 sm:text-2xl">
                Panduan Pakai FroShelf
            </h1>
            <p class="mt-1.5 text-sm leading-relaxed text-slate-500">
                Ikuti langkah berurutan dari atas ke bawah dengan bahasa sehari-hari untuk mencatat transaksi, pesanan WhatsApp, dan mengecek stok freezer.
            </p>
        </div>

        {{-- Segmented Control --}}
        <div class="inline-flex self-start rounded-lg border border-slate-200/80 bg-slate-100/70 p-0.5 text-xs font-medium sm:self-auto"
             role="tablist"
             aria-label="Pilih peran panduan">
            <button type="button"
                    role="tab"
                    data-guidance-tab="staf"
                    aria-selected="{{ $activeTab === 'staf' ? 'true' : 'false' }}"
                    class="rounded-md px-3.5 py-1.5 transition-colors {{ $activeTab === 'staf' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Panduan Staf / Kasir
            </button>
            <button type="button"
                    role="tab"
                    data-guidance-tab="pemilik"
                    aria-selected="{{ $activeTab === 'pemilik' ? 'true' : 'false' }}"
                    class="rounded-md px-3.5 py-1.5 transition-colors {{ $activeTab === 'pemilik' ? 'bg-white text-slate-900 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Panduan Pemilik
            </button>
        </div>
    </section>

    {{-- PANEL 1: STAF / KASIR (Linear ke bawah, rata tengah) --}}
    <section data-guidance-panel="staf" class="{{ $activeTab === 'staf' ? '' : 'hidden' }} mx-auto max-w-3xl">
        <ol class="space-y-4">
            {{-- Langkah 1 --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">1</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Mencatat Pembeli Datang ke Toko</h2>
                        <ol class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                            <li>a. Buka menu <strong class="font-medium text-slate-900">Kasir &amp; Transaksi</strong> lalu pilih kanal <strong class="font-medium text-slate-900">Langsung di Toko</strong>.</li>
                            <li>b. Pilih tipe harga (<strong class="font-medium text-slate-900">Normal</strong> atau <strong class="font-medium text-slate-900">Reseller</strong>) dan masukkan produk beserta jumlahnya.</li>
                            <li>c. Pilih metode bayar (<strong class="font-medium text-slate-900">Tunai / Transfer / QRIS</strong>) lalu simpan — stok terpotong otomatis.</li>
                        </ol>
                        <div class="mt-4">
                            <a href="{{ route('transactions.index') }}" class="text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                                Buka Kasir &amp; Transaksi →
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            {{-- Langkah 2 --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">2</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Mencatat Pesanan WhatsApp &amp; GoSend</h2>
                        <ol class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                            <li>a. Pilih kanal <strong class="font-medium text-slate-900">WhatsApp</strong>, isi nama pemesan &amp; nomor WA.</li>
                            <li>b. Pilih <strong class="font-medium text-slate-900">Ambil di Toko</strong> atau <strong class="font-medium text-slate-900">Kirim GoSend</strong> (isi alamat &amp; ongkir).</li>
                            <li>c. Geser status pesanan bertahap agar seluruh kasir tahu progresnya:</li>
                        </ol>
                        <div class="mt-3.5 flex flex-wrap items-center gap-1.5 text-xs font-medium text-slate-700">
                            <span class="rounded-md border border-slate-200 bg-slate-50 px-2.5 py-1">Menunggu</span>
                            <span class="text-slate-300" aria-hidden="true">→</span>
                            <span class="rounded-md border border-slate-200 bg-slate-50 px-2.5 py-1">Diproses</span>
                            <span class="text-slate-300" aria-hidden="true">→</span>
                            <span class="rounded-md border border-slate-200 bg-slate-50 px-2.5 py-1">Siap / GoSend</span>
                            <span class="text-slate-300" aria-hidden="true">→</span>
                            <span class="rounded-md border border-blue-200 bg-blue-50 px-2.5 py-1 text-[#2563EB]">Selesai</span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('transactions.index') }}" class="text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                                Lihat Daftar Pesanan WA →
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            {{-- Langkah 3 --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">3</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Cek Stok &amp; Lokasi Freezer</h2>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            Gunakan penanda lokasi di halaman <strong class="font-medium text-slate-900">Produk &amp; Stok</strong> agar tidak perlu membuka semua freezer:
                        </p>
                        <ul class="mt-3 space-y-2 text-xs text-slate-600 sm:text-sm">
                            <li class="flex items-center gap-2">
                                <span class="h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>
                                <span><strong class="font-semibold text-slate-900">Freezer 1:</strong> Nugget, sosis, dan produk terlaris harian.</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-2 w-2 shrink-0 rounded-full bg-sky-500"></span>
                                <span><strong class="font-semibold text-slate-900">Freezer 2:</strong> Bakso, olahan seafood, dan kentang beku.</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-2 w-2 shrink-0 rounded-full bg-amber-500"></span>
                                <span><strong class="font-semibold text-slate-900">Gudang Kering:</strong> Saus, mayones, bumbu, dan kemasan.</span>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                                Cek Daftar Produk →
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            {{-- Langkah 4 --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">4</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Jika Muncul Pesan Stok Kurang</h2>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            Pesan merah saat menyimpan transaksi bukan error sistem — FroShelf mencegah stok menjadi minus dan menjaga kas tetap cocok:
                        </p>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600">
                            <li>• <strong class="font-medium text-slate-900">Stok tidak cukup:</strong> Cek fisik freezer, lalu lapor Ibu Shelly jika stok baru masuk belum diinput.</li>
                            <li>• <strong class="font-medium text-slate-900">Uang tunai kurang:</strong> Pastikan uang diterima minimal sama dengan total tagihan.</li>
                        </ul>
                        <p class="mt-4 text-xs text-slate-500">
                            Butuh bantuan cepat di halaman lain? Klik tombol <strong class="text-slate-700">Panduan Cara Pakai</strong> di kanan atas.
                        </p>
                    </div>
                </div>
            </li>
        </ol>
    </section>

    {{-- PANEL 2: PEMILIK TOKO (Linear ke bawah, rata tengah) --}}
    <section data-guidance-panel="pemilik" class="{{ $activeTab === 'pemilik' ? '' : 'hidden' }} mx-auto max-w-3xl">
        <ol class="space-y-4">
            {{-- Langkah 1 Pemilik --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">1</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Membaca Dashboard &amp; Peringatan Harian</h2>
                        <ol class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                            <li>a. Cek <strong class="font-medium text-slate-900">Omzet Hari Ini</strong> dan grafik 7 hari untuk melihat tren penjualan toko.</li>
                            <li>b. Lihat tabel <strong class="font-medium text-slate-900">Peringatan Stok Menipis</strong> agar bisa segera pesan ulang ke supplier.</li>
                            <li>c. Pantau <strong class="font-medium text-slate-900">Produk Mendekati Expired</strong> (≤ 30 hari) untuk prioritas penjualan lebih dulu.</li>
                        </ol>
                        @if (auth()->user()?->isPemilik())
                            <div class="mt-4">
                                <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                                    Buka Dashboard →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </li>

            {{-- Langkah 2 Pemilik --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">2</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Mengatur Harga Normal, Reseller &amp; Stok</h2>
                        <ol class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                            <li>a. Buka menu <strong class="font-medium text-slate-900">Produk &amp; Stok</strong> untuk tambah SKU, perbarui stok masuk, atau ubah tanggal expired.</li>
                            <li>b. Isi <strong class="font-medium text-slate-900">Harga Normal</strong> dan <strong class="font-medium text-slate-900">Harga Reseller</strong> sekaligus agar kasir tinggal pilih.</li>
                            <li>c. Tentukan <strong class="font-medium text-slate-900">Stok Minimum</strong> sebagai batas peringatan otomatis di Dashboard.</li>
                        </ol>
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                                Kelola Produk &amp; Stok →
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            {{-- Langkah 3 Pemilik --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">3</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Mengunduh Laporan CSV &amp; PDF</h2>
                        <ol class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                            <li>a. Buka menu <strong class="font-medium text-slate-900">Rekap Laporan</strong> (khusus akun Pemilik).</li>
                            <li>b. Filter berdasarkan tanggal, kanal penjualan, atau metode pembayaran (Tunai / Transfer / QRIS).</li>
                            <li>c. Klik <strong class="font-medium text-slate-900">Export CSV</strong> untuk Excel atau <strong class="font-medium text-slate-900">Export PDF</strong> untuk arsip cetak.</li>
                        </ol>
                        @if (auth()->user()?->isPemilik())
                            <div class="mt-4">
                                <a href="{{ route('reports.index') }}" class="text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                                    Buka Rekap Laporan →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </li>

            {{-- Langkah 4 Pemilik --}}
            <li class="rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
                <div class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-sm font-bold text-white">4</span>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base font-semibold text-slate-900">Pembagian Hak Akses Pemilik &amp; Staf</h2>
                        <ul class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                            <li>• <strong class="font-medium text-slate-900">Pemilik:</strong> Akses penuh ke Dashboard omzet, Rekap Laporan, Data Toko, dan Kasir.</li>
                            <li>• <strong class="font-medium text-slate-900">Staf / Kasir:</strong> Fokus ke Kasir &amp; Transaksi, cek Produk &amp; Lokasi Freezer, dan Panduan. Akses omzet/laporan diblokir otomatis (403).</li>
                        </ul>
                        <p class="mt-4 text-xs text-slate-500">
                            Pastikan staf selalu login memakai akun Staf masing-masing.
                        </p>
                    </div>
                </div>
            </li>
        </ol>
    </section>

    {{-- Minimal FAQ Accordion --}}
    <section class="mx-auto max-w-3xl rounded-xl border border-slate-200/80 bg-white p-5 sm:p-6">
        <h2 class="text-sm font-semibold text-slate-900">Pertanyaan yang Sering Ditanyakan</h2>

        @php
            $faqs = [
                [
                    'q' => 'Bagaimana jika lupa cara pakai saat sedang ramai melayani pembeli?',
                    'a' => 'Klik tombol "Panduan Cara Pakai" di pojok kanan atas layar. Panel panduan ringkas akan muncul di sisi kanan tanpa menutup halaman yang sedang Anda buka.',
                ],
                [
                    'q' => 'Apakah stok freezer harus dikurangi manual setelah pembeli membayar?',
                    'a' => 'Tidak perlu. Setiap kali transaksi berhasil disimpan di menu Kasir & Transaksi, FroShelf langsung mengurangi sisa stok produk secara otomatis.',
                ],
                [
                    'q' => 'Kenapa akun Staf tidak bisa membuka Dashboard atau Rekap Laporan?',
                    'a' => 'Demi keamanan data keuangan dan rekap omzet Frozen Shelly, halaman Dashboard dan Rekap Laporan hanya dapat dibuka oleh akun Pemilik.',
                ],
                [
                    'q' => 'Apakah FroShelf nyaman dibuka lewat HP saat cek barang di freezer?',
                    'a' => 'Ya. Di layar HP (sampai lebar 360px), tersedia menu navigasi bawah sehingga Anda cukup menekan tab dengan satu jempol.',
                ],
            ];
        @endphp

        <div class="mt-3 divide-y divide-slate-100">
            @foreach ($faqs as $idx => $faq)
                <div class="py-3 first:pt-1 last:pb-0">
                    <button type="button"
                            data-faq-trigger
                            aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                            aria-controls="faq-answer-{{ $idx }}"
                            class="flex w-full items-center justify-between gap-4 py-1 text-left text-sm font-medium text-slate-900 hover:text-[#2563EB]">
                        <span>{{ $faq['q'] }}</span>
                        <svg data-faq-icon
                             class="h-4 w-4 shrink-0 text-slate-400 transition-transform duration-150 {{ $idx === 0 ? 'rotate-180' : '' }}"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div id="faq-answer-{{ $idx }}"
                         class="{{ $idx === 0 ? '' : 'hidden' }} pt-2 pr-6 text-sm leading-relaxed text-slate-600">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
