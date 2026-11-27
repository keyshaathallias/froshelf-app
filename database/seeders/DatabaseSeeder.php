<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed akun demo Pemilik & Staf Kasir FroShelf (UMKM Frozen Shelly)
     * beserta data master: kategori, supplier, customer, dan produk.
     */
    public function run(): void
    {
        // ============================================================
        // 1. AKUN DEMO 
        // ============================================================
        User::updateOrCreate(
            ['email' => 'pemilik@froshelf.test'],
            [
                'name' => 'Ibu Shelly',
                'password' => Hash::make('password'),
                'role' => 'pemilik',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staf@froshelf.test'],
            [
                'name' => 'Staf Kasir 1',
                'password' => Hash::make('password'),
                'role' => 'staf',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staf2@froshelf.test'],
            [
                'name' => 'Staf Kasir 2',
                'password' => Hash::make('password'),
                'role' => 'staf',
                'email_verified_at' => now(),
            ]
        );

        // ============================================================
        // 2. DATA MASTER: KATEGORI (F-03 — Vany)
        // ============================================================
        $kategori = [
            ['nama_kategori' => 'Nugget & Sosis', 'deskripsi' => 'Produk nugget dan sosis beku'],
            ['nama_kategori' => 'Bakso & Olahan Ikan', 'deskripsi' => 'Bakso, otak-otak, dan olahan ikan'],
            ['nama_kategori' => 'Kentang & Camilan Beku', 'deskripsi' => 'Kentang goreng dan camilan beku'],
            ['nama_kategori' => 'Saus & Bumbu Gudang', 'deskripsi' => 'Saus dan bumbu di gudang kering'],
        ];
        foreach ($kategori as $k) {
            Category::updateOrCreate(
                ['nama_kategori' => $k['nama_kategori']],
                $k
            );
        }

        // ============================================================
        // 3. DATA MASTER: SUPPLIER (F-03 — Vany)
        // ============================================================
        Supplier::updateOrCreate(
            ['nama_supplier' => 'PT Sumber Pangan Beku'],
            [
                'nomor_telepon' => '081234567890',
                'produk_dipasok' => 'Nugget, Sosis, Bakso',
                'termin_pembayaran' => 'transfer',
            ]
        );

        Supplier::updateOrCreate(
            ['nama_supplier' => 'CV Laut Segar'],
            [
                'nomor_telepon' => '081298765432',
                'produk_dipasok' => 'Olahan Ikan, Otak-otak',
                'termin_pembayaran' => 'tempo',
            ]
        );

        Supplier::updateOrCreate(
            ['nama_supplier' => 'Toko Bumbu Jaya'],
            [
                'nomor_telepon' => '081211112222',
                'produk_dipasok' => 'Saus, Bumbu',
                'termin_pembayaran' => 'tunai',
            ]
        );

        // ============================================================
        // 4. DATA MASTER: CUSTOMER (F-03 — Vany)
        // ============================================================
        Customer::updateOrCreate(
            ['nama_pelanggan' => 'Ibu Siti'],
            [
                'tipe_pelanggan' => 'umum',
                'nomor_whatsapp' => '081312345678',
                'alamat_pengiriman' => 'Jl. Merdeka No. 10, Jakarta',
            ]
        );

        Customer::updateOrCreate(
            ['nama_pelanggan' => 'Reseller Berkah Jaya'],
            [
                'tipe_pelanggan' => 'reseller',
                'nomor_whatsapp' => '081398765432',
                'alamat_pengiriman' => 'Jl. Sudirman No. 25, Jakarta',
            ]
        );

        Customer::updateOrCreate(
            ['nama_pelanggan' => 'Warung Makan Pak Budi'],
            [
                'tipe_pelanggan' => 'umum',
                'nomor_whatsapp' => '081355556666',
                'alamat_pengiriman' => 'Jl. Ahmad Yani No. 5, Jakarta',
            ]
        );

        // ============================================================
        // 5. DATA MASTER: PRODUK (F-03 — Vany)
        //    ⚠️ Nama kolom harus PERSIS agar terbaca Dashboard & Transaksi
        // ============================================================
        // Ambil ID kategori berdasarkan nama (biar tidak hardcode 1,2,3,4)
        $catNugget  = Category::where('nama_kategori', 'Nugget & Sosis')->first()->id;
        $catBakso   = Category::where('nama_kategori', 'Bakso & Olahan Ikan')->first()->id;
        $catKentang = Category::where('nama_kategori', 'Kentang & Camilan Beku')->first()->id;
        $catSaus    = Category::where('nama_kategori', 'Saus & Bumbu Gudang')->first()->id;

        $produk = [
            [
                'kode_sku' => 'NGS-001', 'nama_produk' => 'Nugget Ayam 500g',
                'category_id' => $catNugget,
                'harga_normal' => 25000, 'harga_reseller' => 22000,
                'stok_saat_ini' => 50, 'stok_minimum' => 10,
                'tanggal_expired' => '2026-12-31', 'lokasi_penyimpanan' => 'Freezer 1',
            ],
            [
                'kode_sku' => 'NGS-002', 'nama_produk' => 'Nugget Sapi 500g',
                'category_id' => $catNugget,
                'harga_normal' => 30000, 'harga_reseller' => 27000,
                'stok_saat_ini' => 40, 'stok_minimum' => 10,
                'tanggal_expired' => '2026-12-30', 'lokasi_penyimpanan' => 'Freezer 1',
            ],
            [
                'kode_sku' => 'SOS-001', 'nama_produk' => 'Sosis Ayam 500g',
                'category_id' => $catNugget,
                'harga_normal' => 28000, 'harga_reseller' => 25000,
                'stok_saat_ini' => 35, 'stok_minimum' => 8,
                'tanggal_expired' => '2026-12-25', 'lokasi_penyimpanan' => 'Freezer 2',
            ],
            [
                'kode_sku' => 'BSO-001', 'nama_produk' => 'Bakso Sapi 250g',
                'category_id' => $catBakso,
                'harga_normal' => 20000, 'harga_reseller' => 18000,
                'stok_saat_ini' => 60, 'stok_minimum' => 15,
                'tanggal_expired' => '2026-12-28', 'lokasi_penyimpanan' => 'Freezer 2',
            ],
            [
                'kode_sku' => 'OTK-001', 'nama_produk' => 'Otak-otak Ikan 200g',
                'category_id' => $catBakso,
                'harga_normal' => 15000, 'harga_reseller' => 13000,
                'stok_saat_ini' => 45, 'stok_minimum' => 12,
                'tanggal_expired' => '2026-12-20', 'lokasi_penyimpanan' => 'Freezer 2',
            ],
            [
                'kode_sku' => 'KNT-001', 'nama_produk' => 'Kentang Goreng 1kg',
                'category_id' => $catKentang,
                'harga_normal' => 22000, 'harga_reseller' => 19000,
                'stok_saat_ini' => 70, 'stok_minimum' => 20,
                'tanggal_expired' => '2026-12-29', 'lokasi_penyimpanan' => 'Freezer 1',
            ],
            [
                'kode_sku' => 'KNT-002', 'nama_produk' => 'Kentang Wedges 500g',
                'category_id' => $catKentang,
                'harga_normal' => 18000, 'harga_reseller' => 16000,
                'stok_saat_ini' => 55, 'stok_minimum' => 15,
                'tanggal_expired' => '2026-12-27', 'lokasi_penyimpanan' => 'Freezer 1',
            ],
            [
                'kode_sku' => 'SSS-001', 'nama_produk' => 'Saus Sambal 250ml',
                'category_id' => $catSaus,
                'harga_normal' => 8000, 'harga_reseller' => 7000,
                'stok_saat_ini' => 100, 'stok_minimum' => 25,
                'tanggal_expired' => '2027-06-30', 'lokasi_penyimpanan' => 'Gudang Kering',
            ],
            [
                'kode_sku' => 'SSS-002', 'nama_produk' => 'Saus Tomat 250ml',
                'category_id' => $catSaus,
                'harga_normal' => 8000, 'harga_reseller' => 7000,
                'stok_saat_ini' => 90, 'stok_minimum' => 25,
                'tanggal_expired' => '2027-06-30', 'lokasi_penyimpanan' => 'Gudang Kering',
            ],
            [
                'kode_sku' => 'BMB-001', 'nama_produk' => 'Bumbu Kaldu 100g',
                'category_id' => $catSaus,
                'harga_normal' => 5000, 'harga_reseller' => 4000,
                'stok_saat_ini' => 120, 'stok_minimum' => 30,
                'tanggal_expired' => '2027-08-31', 'lokasi_penyimpanan' => 'Gudang Kering',
            ],
        ];

        foreach ($produk as $p) {
            Product::updateOrCreate(
                ['kode_sku' => $p['kode_sku']],
                $p
            );
        }
    }
}
