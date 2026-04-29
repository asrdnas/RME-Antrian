<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanKlinik extends Model
{
    protected $table = 'pengumumankliniks';
    protected $fillable = [
        'navbar_id',
        'judul',
        'tanggal',
        'deskripsi',
        'gambar',
    ];

    public function navbar()
    {
        return $this->belongsTo(Navbar::class);
    }
}
