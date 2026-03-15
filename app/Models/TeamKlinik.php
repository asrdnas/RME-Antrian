<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamKlinik extends Model
{
    protected $fillable = [
        'image',
        'hero_title',
        'hero_description',
        'description',
    ];
}
