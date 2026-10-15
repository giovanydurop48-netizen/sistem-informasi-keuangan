
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelian_stoks', function (Blueprint $table) {
            $table->id();

            // Produk yang dibeli
            $table->foreignId('produk_id')
                ->nullable()
                ->constrained('produks')
                ->nullOnDelete();

            // Salinan identitas produk untuk catatan transaksi
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('satuan', 50);

            // Detail pembelian
            $table->string('supplier')->nullable();
            $table->unsignedInteger('jumlah');
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->date('tanggal_pembelian');
            $table->text('keterangan')->nullable();

            // Stok baru bertambah setelah status diterima
            $table->enum('status', ['menunggu', 'diterima'])
                ->default('menunggu');

            $table->timestamp('diterima_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelian_stoks');
    }
};
