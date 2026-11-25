@php
    $user = auth()->user();
    $isPemilik = $user && $user->isPemilik();
    $routeName = request()->route()?->getName() ?? '';

    if ($routeName === 'dashboard') {
        $drawerTitle = 'Panduan Halaman Dashboard';
        $drawerSubtitle = 'Cara membaca ringkasan harian Frozen Shelly dalam 30 detik.';
        $drawerSteps = [
            [
                'title' => 'Cek Stok Menipis & Expired',
                'body' => 'Lihat dua tabel di bagian bawah setiap pagi sebelum buka toko agar barang cepat habis bisa segera dipesan ke supplier.',
            ],
            [
                'title' => 'Pantau Pesanan WA Aktif',
                'body' => 'Angka Pesanan WA Aktif menunjukkan pesanan yang masih berjalan (Ambil di Toko / GoSend) agar tidak ada chat terlewat.',
            ],
            [
                'title' => 'Unduh Rekap Harian',
                'body' => 'Buka menu Rekap Laporan di sidebar untuk mencocokkan total Tunai, Transfer, dan QRIS lalu unduh CSV atau PDF.',
            ],
        ];
    } elseif (str_starts_with($routeName, 'transactions.')) {
        $drawerTitle = 'Panduan Kasir & Transaksi';
        $drawerSubtitle = 'Langkah cepat mencatat pembeli di toko maupun pesanan WhatsApp.';
        $drawerSteps = [
            [
                'title' => 'Pilih Kanal & Tipe Harga',
                'body' => 'Pilih "Langsung di Toko" untuk pembeli di kasir atau "WhatsApp" untuk Ambil di Toko / GoSend, lalu pilih Harga Normal atau Reseller.',
            ],
            [
                'title' => 'Tambahkan Produk',
                'body' => 'Sisa stok dan lokasi (Freezer 1, Freezer 2, Gudang Kering) tampil langsung. Stok berkurang otomatis saat disimpan.',
            ],
            [
                'title' => 'Perbarui Status Pesanan WA',
                'body' => 'Geser status bertahap dari Menunggu → Diproses → Siap Diambil / GoSend → Selesai supaya staf lain tahu progresnya.',
            ],
        ];
    } elseif (str_starts_with($routeName, 'products.')) {
        $drawerTitle = 'Panduan Produk & Freezer';
        $drawerSubtitle = 'Cara cepat melihat lokasi simpan dan sisa stok barang.';
        $drawerSteps = [
            [
                'title' => 'Kenali Lokasi Penyimpanan',
                'body' => 'Freezer 1 untuk nugget & sosis harian, Freezer 2 untuk bakso & seafood, Gudang Kering untuk saus dan bumbu.',
            ],
            [
                'title' => 'Pantau Tanda Stok Menipis',
                'body' => 'Produk dengan sisa stok di bawah batas minimum ditandai warna kuning agar segera diinformasikan ke Pemilik.',
            ],
            [
                'title' => 'Cek Harga Normal vs Reseller',
                'body' => 'Setiap produk punya dua harga sekaligus supaya kasir tidak perlu menghafal potongan harga grosir.',
            ],
        ];
    } else {
        $drawerTitle = $isPemilik ? 'Panduan Cepat Pemilik' : 'Panduan Cepat Staf Kasir';
        $drawerSubtitle = 'Ringkasan langkah utama menggunakan FroShelf sehari-hari.';
        $drawerSteps = $isPemilik
            ? [
                [
                    'title' => 'Pantau Dashboard Harian',
                    'body' => 'Cek omzet hari ini, pesanan WA aktif, stok menipis, serta produk mendekati tanggal expired.',
                ],
                [
                    'title' => 'Kelola Data Toko',
                    'body' => 'Atur daftar produk, harga normal & reseller, kategori, supplier, dan pelanggan dari grup Data Toko di sidebar.',
                ],
                [
                    'title' => 'Unduh Laporan CSV / PDF',
                    'body' => 'Buka Rekap Laporan untuk melihat omzet per metode bayar (Tunai, Transfer, QRIS) dan unduh laporan.',
                ],
            ]
            : [
                [
                    'title' => 'Catat Pembeli di Kasir',
                    'body' => 'Buka Kasir & Transaksi, pilih kanal Toko, masukkan produk dan metode bayar, lalu simpan — stok terpotong otomatis.',
                ],
                [
                    'title' => 'Catat Pesanan WhatsApp',
                    'body' => 'Isi nama pemesan, pilih Ambil di Toko atau GoSend, lalu perbarui status pesanan secara bertahap sampai Selesai.',
                ],
                [
                    'title' => 'Cek Lokasi Freezer',
                    'body' => 'Buka menu Produk & Stok kapan saja untuk mengecek apakah barang ada di Freezer 1, Freezer 2, atau Gudang Kering.',
                ],
            ];
    }
@endphp

<div id="guidance-drawer-backdrop"
     class="fixed inset-0 z-40 hidden bg-slate-900/25"
     aria-hidden="true"></div>

<aside id="guidance-drawer"
       class="fixed inset-y-0 right-0 z-50 flex w-full max-w-[340px] translate-x-full flex-col border-l border-slate-200 bg-white shadow-xl transition-transform duration-200 ease-out"
       aria-hidden="true"
       aria-labelledby="guidance-drawer-title">
    <div class="flex items-start justify-between gap-3 border-b border-slate-100 px-5 py-4">
        <div>
            <h2 id="guidance-drawer-title" class="text-sm font-semibold text-slate-900">{{ $drawerTitle }}</h2>
            <p class="mt-0.5 text-xs leading-relaxed text-slate-500">{{ $drawerSubtitle }}</p>
        </div>
        <button type="button"
                data-close-guidance
                class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                aria-label="Tutup panduan cepat">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="flex-1 space-y-4 overflow-y-auto px-5 py-5">
        <ol class="space-y-4">
            @foreach ($drawerSteps as $index => $step)
                <li class="flex gap-3">
                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-blue-200 bg-blue-50 text-xs font-semibold text-[#2563EB]">
                        {{ $index + 1 }}
                    </span>
                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-slate-900">{{ $step['title'] }}</h3>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">{{ $step['body'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>

        <div class="border-t border-slate-100 pt-4">
            <a href="{{ route('guidance.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2563EB] hover:text-blue-800">
                <span>Lihat Pusat Panduan Lengkap</span>
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>

    <div class="border-t border-slate-100 p-4">
        <button type="button"
                data-close-guidance
                class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white transition-colors hover:bg-slate-800">
            Mengerti, Tutup Panduan
        </button>
    </div>
</aside>
