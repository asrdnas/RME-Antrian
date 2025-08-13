<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatAntrian extends Model
{
    protected $fillable = [
        'no_antrian',
        'no_rme',
        'nama_pasien',
        'alamat_pasien',
        'status',
        'tanggal',
        'tanggal_reset',
    ];
}
