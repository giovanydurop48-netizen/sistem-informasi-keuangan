<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas', function (Blueprint $table) {
            $table->id();

            $table->enum('jenis', [
                'masuk',
                'keluar'
            ]);

            $table->decimal(
                'jumlah',
                15,
                2
            );

            $table->decimal(
                'saldo_sebelum',
                15,
                2
            );

            $table->decimal(
                'saldo_sesudah',
                15,
                2
            );

            $table->string(
                'sumber'
            )->nullable();

            $table->text(
                'keterangan'
            )->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};