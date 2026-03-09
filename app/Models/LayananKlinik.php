<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananKlinik extends Model
{
    protected $fillable = [
        'navbar_id',
        'nama',
        'tag',
        'deskripsi',
        'gambar',
        'is_featured',
    ];

    public function navbar()
    {
        return $this->belongsTo(Navbar::class);
    }
}
