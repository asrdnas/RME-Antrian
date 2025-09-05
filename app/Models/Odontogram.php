<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    use HasFactory;

    // Nama tabel (opsional, kalau tidak sama dengan plural)
    protected $table = 'odontogram';

    // Field yang bisa diisi
    protected $fillable = [
        'rekam_medis_id',
        'kode_gigi',
        'kondisi',
        'diagnosa_icd',
        'tindakan',
        'catatan',
    ];

    // Relasi ke Rekam Medis
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}
