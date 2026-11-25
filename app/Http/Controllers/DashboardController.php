<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Ringkas Pemilik (F-09) dengan fallback aman
     * jika tabel products/transactions/categories belum dimigrasi anggota lain.
     */
    public function index(Request $request): View
    {
        $period = $request->query('periode', 'hari_ini');
        if (! in_array($period, ['hari_ini', '7_hari', 'bulan_ini'], true)) {
            $period = 'hari_ini';
        }

        $hasProducts = Schema::hasTable('products');
        $hasTransactions = Schema::hasTable('transactions');
        $hasTransactionDetails = Schema::hasTable('transaction_details');
        $hasCategories = Schema::hasTable('categories');

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        [$rangeStart, $rangeLabel] = match ($period) {
            '7_hari' => [$today->copy()->subDays(6)->startOfDay(), '7 Hari Terakhir'],
            'bulan_ini' => [$today->copy()->startOfMonth(), 'Bulan Ini'],
            default => [$today->copy()->startOfDay(), 'Hari Ini'],
        };

        $omzetPeriode = 0;
        $omzetKemarin = 0;
        $omzetChangePercent = null;
        $totalTransaksi = 0;
        $transaksiToko = 0;
        $transaksiWa = 0;
        $pesananWaAktif = 0;

        $totalProduk = 0;
        $lowStockProducts = collect();
        $expiringProducts = collect();
        $dailyRevenue = collect();
        $categorySales = collect();

        if ($hasTransactions) {
            $baseQuery = DB::table('transactions')
                ->where('created_at', '>=', $rangeStart);

            $omzetPeriode = (int) (clone $baseQuery)->sum('total_harga');
            $totalTransaksi = (int) (clone $baseQuery)->count();
            $transaksiToko = (int) (clone $baseQuery)->where('kanal_penjualan', 'toko')->count();
            $transaksiWa = (int) (clone $baseQuery)->where('kanal_penjualan', 'wa')->count();

            $pesananWaAktif = (int) DB::table('transactions')
                ->where('kanal_penjualan', 'wa')
                ->whereIn('status_pesanan', ['menunggu', 'diproses', 'siap_diambil_dikirim'])
                ->count();

            if ($period === 'hari_ini') {
                $omzetKemarin = (int) DB::table('transactions')
                    ->whereDate('created_at', $yesterday)
                    ->sum('total_harga');

                if ($omzetKemarin > 0) {
                    $omzetChangePercent = (int) round((($omzetPeriode - $omzetKemarin) / $omzetKemarin) * 100);
                }
            }

            // Grafik Omzet 7 Hari Terakhir
            $start7Days = $today->copy()->subDays(6)->startOfDay();
            $rawDaily = DB::table('transactions')
                ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
                ->where('created_at', '>=', $start7Days)
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            for ($i = 6; $i >= 0; $i--) {
                $date = $today->copy()->subDays($i);
                $key = $date->toDateString();
                $dailyRevenue->push([
                    'label' => $dayNames[$date->dayOfWeek],
                    'date' => $date->format('d/m'),
                    'total' => (int) ($rawDaily[$key] ?? 0),
                ]);
            }
        } else {
            $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            for ($i = 6; $i >= 0; $i--) {
                $date = $today->copy()->subDays($i);
                $dailyRevenue->push([
                    'label' => $dayNames[$date->dayOfWeek],
                    'date' => $date->format('d/m'),
                    'total' => 0,
                ]);
            }
        }

        if ($hasProducts) {
            $totalProduk = (int) DB::table('products')->count();

            $lowStockProducts = DB::table('products')
                ->whereColumn('stok_saat_ini', '<=', 'stok_minimum')
                ->orderBy('stok_saat_ini')
                ->limit(6)
                ->get(['id', 'kode_sku', 'nama_produk', 'lokasi_penyimpanan', 'stok_saat_ini', 'stok_minimum']);

            $expiringLimit = $today->copy()->addDays(30)->toDateString();
            $expiringProducts = DB::table('products')
                ->whereNotNull('tanggal_expired')
                ->whereDate('tanggal_expired', '<=', $expiringLimit)
                ->orderBy('tanggal_expired')
                ->limit(6)
                ->get(['id', 'kode_sku', 'nama_produk', 'lokasi_penyimpanan', 'tanggal_expired', 'stok_saat_ini']);
        }

        if ($hasTransactions && $hasTransactionDetails && $hasProducts && $hasCategories) {
            $categorySales = DB::table('transaction_details')
                ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
                ->join('products', 'products.id', '=', 'transaction_details.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('transactions.created_at', '>=', $rangeStart)
                ->selectRaw('categories.nama_kategori, SUM(transaction_details.subtotal) as total_omzet, SUM(transaction_details.qty) as total_qty')
                ->groupBy('categories.id', 'categories.nama_kategori')
                ->orderByDesc('total_omzet')
                ->limit(5)
                ->get();
        }

        $maxDailyRevenue = max(1, (int) $dailyRevenue->max('total'));
        $totalCategoryRevenue = max(1, (int) $categorySales->sum('total_omzet'));
        $totalAlerts = $lowStockProducts->count() + $expiringProducts->count();

        return view('dashboard', [
            'period' => $period,
            'rangeLabel' => $rangeLabel,
            'hasProducts' => $hasProducts,
            'hasTransactions' => $hasTransactions,
            'omzetPeriode' => $omzetPeriode,
            'omzetChangePercent' => $omzetChangePercent,
            'totalTransaksi' => $totalTransaksi,
            'transaksiToko' => $transaksiToko,
            'transaksiWa' => $transaksiWa,
            'pesananWaAktif' => $pesananWaAktif,
            'totalProduk' => $totalProduk,
            'totalAlerts' => $totalAlerts,
            'lowStockProducts' => $lowStockProducts,
            'expiringProducts' => $expiringProducts,
            'dailyRevenue' => $dailyRevenue,
            'maxDailyRevenue' => $maxDailyRevenue,
            'categorySales' => $categorySales,
            'totalCategoryRevenue' => $totalCategoryRevenue,
        ]);
    }
}
