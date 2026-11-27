<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan', 'tipe_pelanggan', 'nomor_whatsapp', 'alamat_pengiriman'
    ];
}
