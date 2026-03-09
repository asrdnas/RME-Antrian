<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasKlinik extends Model
{
    protected $fillable = [
        'navbar_id',
        'nama',
        'deskripsi',
        'gambar',
        'is_featured',
    ];

    public function navbar()
    {
        return $this->belongsTo(Navbar::class);
    }
}
