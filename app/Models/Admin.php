<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
