<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class TenagaMedis extends Authenticatable
{
     use HasRoles;
    protected $guard = 'tenaga_medis';

    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'dokter_id');
    }
}
