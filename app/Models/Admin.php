<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Admin extends Authenticatable implements FilamentUser
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin';
    }
}