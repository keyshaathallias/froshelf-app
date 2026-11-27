<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sku')->unique();
            $table->string('nama_produk');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->decimal('harga_normal', 12, 2);
            $table->decimal('harga_reseller', 12, 2);
            $table->integer('stok_saat_ini')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->date('tanggal_expired');
            $table->enum('lokasi_penyimpanan', ['Freezer 1', 'Freezer 2', 'Gudang Kering']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
