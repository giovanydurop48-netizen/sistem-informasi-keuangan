<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Manajemen Stok
|--------------------------------------------------------------------------
*/

Route::prefix('stok')->group(function () {

    // Dashboard stok
    Route::get('/', [StokController::class, 'index'])
        ->name('stok.index');

    // Produk
    Route::get('/produk', [StokController::class, 'produk'])
        ->name('stok.produk');

    Route::post('/produk', [StokController::class, 'storeProduk'])
        ->name('stok.produk.store');

    // Kategori
    Route::post('/kategori', [StokController::class, 'storeKategori'])
        ->name('stok.kategori.store');

    Route::put('/kategori/{id}', [StokController::class, 'updateKategori'])
        ->name('stok.kategori.update');

    // Halaman transaksi stok
    Route::get('/transaksi', [StokController::class, 'transaksi'])
        ->name('stok.transaksi');

    // Catat pembelian/barang masuk
    Route::post('/pembelian', [StokController::class, 'pembelian'])
        ->name('stok.pembelian');

    // Terima pembelian agar stok bertambah
    Route::post('/pembelian/{id}/terima', [
        StokController::class,
        'terimaPembelian'
    ])->name('stok.pembelian.terima');

    // Barang keluar
    Route::post('/barang-keluar', [
        StokController::class,
        'barangKeluar'
    ])->name('stok.barang-keluar');

    // Riwayat stok
    Route::get('/riwayat', [StokController::class, 'riwayat'])
        ->name('stok.riwayat');

    // Laporan keuntungan
    Route::get('/keuntungan', [StokController::class, 'keuntungan'])
        ->name('stok.keuntungan');


});

/*
|--------------------------------------------------------------------------
| Penjualan
|--------------------------------------------------------------------------
*/

Route::prefix('penjualan')->group(function () {

    Route::get('/', [PenjualanController::class, 'index'])
        ->name('penjualan.index');

    Route::post('/', [PenjualanController::class, 'store'])
        ->name('penjualan.store');

    Route::get('/{id}/nota', [PenjualanController::class, 'nota'])
        ->name('penjualan.nota');

    Route::get('/{id}', [PenjualanController::class, 'show'])
        ->name('penjualan.show');
});
