<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function pengumuman()
    {
        $pengumumanKliniks = \App\Models\pengumumanklinik::with('navbar')->get();
        return view('page.pengumumanklinik', compact('pengumumanKliniks'));
    }
}
