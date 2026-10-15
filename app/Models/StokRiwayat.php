<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokRiwayat extends Model
{
    protected $fillable = [
        'produk_id',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'harga',
        'keterangan'
    ];


    public function produk()
    {
        return $this->belongsTo(
            Produk::class
        );
    }
}