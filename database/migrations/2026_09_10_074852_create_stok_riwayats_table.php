<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_riwayats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produk_id')
                  ->constrained('produks')
                  ->cascadeOnDelete();

            $table->enum('jenis', [
                'pembelian',
                'penjualan',
                'rusak',
                'expired',
                'diberikan',
                'bsb'
            ]);

            $table->integer('jumlah');

            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');

            $table->decimal('harga', 15, 2)->default(0);

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_riwayats');
    }
};