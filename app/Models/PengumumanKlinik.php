<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengumumanklinik extends Model
{
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
