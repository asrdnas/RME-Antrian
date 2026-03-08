<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingInfo extends Model
{
    protected $table = 'setting_infos';

    protected $fillable = [

        // HERO / INFORMASI KLINIK
        'judul_klinik1',
        'judul_highlight1',
        'judul_klinik2',
        'judul_highlight2',
        'deskripsi_klinik',
        'foto_founder',
        'nama_founder',
        'jabatan_founder',

        // KONTAK
        'nomor_whatsapp',

        // LOKASI
        'alamat',
        'hari_operasional',
        'jam_operasional',
        'embed_maps',
    ];
}