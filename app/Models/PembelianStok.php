<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianStok extends Model
{
    protected $table = 'pembelian_stoks';

    protected $fillable = [
        'produk_id',
        'kode_produk',
        'nama_produk',
        'satuan',
        'supplier',
        'jumlah',
        'harga_beli',
        'tanggal_pembelian',
        'keterangan',
        'status',
        'diterima_pada',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_beli' => 'decimal:2',
        'tanggal_pembelian' => 'date',
        'diterima_pada' => 'datetime',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}