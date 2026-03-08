<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutKlinik extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'highlight',
        'description',
        'image',
    ];
}
