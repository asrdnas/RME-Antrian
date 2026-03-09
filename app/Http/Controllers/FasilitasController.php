<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasKlinik;

class FasilitasController extends Controller
{
    public function fasilitas()
    {
        $fasilitasKliniks = FasilitasKlinik::with('navbar')->get();
        return view('page.fasilitas', compact('fasilitasKliniks'));
    }
}
