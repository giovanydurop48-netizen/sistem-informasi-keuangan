<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'kategori_id',
        'kode_produk',
        'nama_produk',
        'satuan',
        'stok',
        'harga_beli',
        'harga_jual',
        'stok_minimum'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function riwayatStok()
    {
        return $this->hasMany(StokRiwayat::class);
    }
     public function penjualan()
     {
        return $this->hasMany(DelailPenjualan::class);
     }


}