<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter';

    protected $fillable = [
        'tenaga_medis_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function tenagaMedis()
    {
        return $this->belongsTo(TenagaMedis::class);
    }
}
