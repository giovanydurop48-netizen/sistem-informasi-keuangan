<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'invoice',
        'nama_pembeli',
        'tanggal',
        'total',
        'total_modal',
        'total_keuntungan',
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}