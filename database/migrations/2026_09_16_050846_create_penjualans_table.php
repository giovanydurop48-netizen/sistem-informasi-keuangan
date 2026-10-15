<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel penjualans
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {

            // ID transaksi
            $table->id();

            // Nomor invoice / nota
            $table->string('invoice')->unique();

            // Nama pembeli
            $table->string('nama_pembeli');

            // Tanggal transaksi
            $table->date('tanggal');

            // Total harga penjualan
            $table->decimal('total', 15, 2)->default(0);

            // Total modal barang yang terjual
            $table->decimal('total_modal', 15, 2)->default(0);

            // Total keuntungan
            $table->decimal('total_keuntungan', 15, 2)->default(0);

            // Waktu dibuat dan diubah
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel penjualans
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};