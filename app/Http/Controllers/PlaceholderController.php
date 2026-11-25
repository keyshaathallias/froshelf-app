<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PlaceholderController extends Controller
{
    /**
     * Menampilkan halaman placeholder ramah untuk modul yang dikerjakan anggota tim lain.
     */
    public function show(string $module): View
    {
        $modules = [
            'transactions' => [
                'title' => 'Kasir & Transaksi',
                'code' => 'F-04 / F-05 / F-06',
                'owner' => 'Kevin & Ergi',
                'description' => 'Halaman pencatatan transaksi langsung di toko, pesanan WhatsApp (Ambil di Toko / GoSend), kalkulasi kembalian otomatis, dan pembaruan status pesanan bertahap.',
                'tips' => [
                    'Pilih kanal Toko untuk pembeli di kasir, atau WhatsApp untuk pesanan ambil sendiri / kirim GoSend.',
                    'Stok produk akan berkurang otomatis saat transaksi disimpan agar tidak terjadi selisih.',
                    'Gunakan status Menunggu → Diproses → Siap Diambil / GoSend → Selesai untuk memantau pesanan WA.',
                ],
            ],
            'products' => [
                'title' => 'Produk & Stok Freezer',
                'code' => 'F-03',
                'owner' => 'Vany',
                'description' => 'Halaman daftar seluruh produk Frozen Shelly lengkap dengan kode SKU, harga normal & reseller, sisa stok, tanggal expired, dan lokasi penyimpanan (Freezer 1, Freezer 2, Gudang Kering).',
                'tips' => [
                    'Cek badge lokasi (Freezer 1, Freezer 2, atau Gudang Kering) sebelum mengambil barang untuk pembeli.',
                    'Perhatikan produk dengan tanda kuning (stok menipis) atau merah (mendekati expired).',
                ],
            ],
            'categories' => [
                'title' => 'Kategori Produk',
                'code' => 'F-03',
                'owner' => 'Vany',
                'description' => 'Pengelolaan kategori produk seperti Nugget & Sosis, Bakso & Olahan Ikan, Kentang & Camilan Beku, serta Saus & Bumbu Gudang.',
                'tips' => [
                    'Kategori memudahkan pencarian produk di kasir dan pengelompokan laporan penjualan.',
                ],
            ],
            'suppliers' => [
                'title' => 'Data Supplier',
                'code' => 'F-03',
                'owner' => 'Vany',
                'description' => 'Catatan kontak pemasok frozen food, daftar produk yang dipasok, serta termin pembayaran (Tunai, Transfer, Tempo).',
                'tips' => [
                    'Simpan nomor telepon supplier agar mudah menghubungi saat stok di dashboard mulai menipis.',
                ],
            ],
            'customers' => [
                'title' => 'Data Pelanggan & Reseller',
                'code' => 'F-03',
                'owner' => 'Vany',
                'description' => 'Daftar pelanggan umum maupun reseller beserta nomor WhatsApp dan alamat kirim untuk mempercepat pesanan berulang.',
                'tips' => [
                    'Pelanggan bertipe Reseller otomatis mempermudah pengecekan harga khusus grosir saat transaksi.',
                ],
            ],
            'reports' => [
                'title' => 'Rekap Laporan & Export CSV/PDF',
                'code' => 'F-07 / F-08',
                'owner' => 'Afif',
                'description' => 'Rekap omzet harian/bulanan per metode pembayaran (Tunai, Transfer, QRIS), kanal penjualan, kondisi stok & expired, serta unduh langsung file CSV dan PDF.',
                'tips' => [
                    'Pilih rentang tanggal terlebih dahulu sebelum klik tombol Unduh CSV atau Unduh PDF.',
                    'Cocokkan total Tunai di laporan dengan uang fisik di laci kasir saat tutup toko.',
                ],
            ],
        ];

        $meta = $modules[$module] ?? [
            'title' => 'Modul Sedang Disiapkan',
            'code' => '-',
            'owner' => 'Tim FroShelf',
            'description' => 'Modul ini sedang dalam tahap pengembangan oleh anggota tim terkait.',
            'tips' => ['Silakan buka menu Panduan Pakai untuk mempelajari alur penggunaan sistem.'],
        ];

        return view('placeholder', [
            'moduleKey' => $module,
            'meta' => $meta,
        ]);
    }
}
