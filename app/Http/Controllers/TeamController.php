<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenagaMedis;

class TeamController extends Controller
{
    public function team()
    {
       $dokters = TenagaMedis::with('JadwalDokter')->get();

        return view('page.team', compact('dokters'));
    }
}
