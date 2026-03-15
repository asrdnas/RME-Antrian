<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenagaMedis;
use App\Models\TeamKlinik;

class TeamController extends Controller
{
    public function team()
    {
        $teamKlinik = TeamKlinik::first();
        $dokters = TenagaMedis::with('JadwalDokter')->get();

        return view('page.team', compact('teamKlinik', 'dokters'));
    }
}
