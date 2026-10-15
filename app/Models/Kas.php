<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $table = 'kas';

    protected $fillable = [
        'jenis',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'sumber',
        'keterangan',
    ];
}