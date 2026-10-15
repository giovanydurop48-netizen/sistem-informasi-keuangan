<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {

            $table->id();

            // Relasi ke tabel penjualans
            $table->foreignId('penjualan_id')
                  ->constrained('penjualans')
                  ->cascadeOnDelete();

            // Relasi ke tabel produks
            $table->foreignId('produk_id')
                  ->constrained('produks')
                  ->cascadeOnDelete();

            // Jumlah produk yang terjual
            $table->integer('jumlah');

            // Harga beli saat transaksi
            $table->decimal('harga_beli', 15, 2);

            // Harga jual saat transaksi
            $table->decimal('harga_jual', 15, 2);

            // Total harga produk
            $table->decimal('subtotal', 15, 2);

            // Keuntungan dari produk ini
            $table->decimal('keuntungan', 15, 2);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_penjualans');
    }
};