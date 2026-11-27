<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_sku', 'nama_produk', 'category_id',
        'harga_normal', 'harga_reseller',
        'stok_saat_ini', 'stok_minimum',
        'tanggal_expired', 'lokasi_penyimpanan',
    ];

    protected $casts = [
        'tanggal_expired' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
