<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class TenagaMedis extends Authenticatable implements FilamentUser
{
     use HasRoles;
    protected $guard = 'tenaga_medis';

    protected $fillable = [
        'username', 'name', 'slug', 'email', 'password','photo',
        'jenis_dokter',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'dokter_id');
    }

    public function jadwalDokter()
    {
    return $this->hasMany(JadwalDokter::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'tenaga-medis';
    }

}