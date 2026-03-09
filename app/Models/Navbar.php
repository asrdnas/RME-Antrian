<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];
    public function layananKliniks()
    {
        return $this->hasMany(LayananKlinik::class);
    }
}
