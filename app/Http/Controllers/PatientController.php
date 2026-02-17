<?php

// app/Http/Controllers/PatientController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'nama_kk' => 'required|string|max:255',
        'nama_pasien' => 'required|string|max:255',
        'jenis_kelamin' => 'required|string',
        'alamat_pasien' => 'required|string',
        'no_tlp_pasien' => 'required|string',
        'pekerjaan_pasien' => 'required|string',
    ]);

    // Generate otomatis No RME
    $data['no_rme'] = Patient::generateNoRme();

    // Default status validasi
    $data['status_validasi'] = 'pending';

    // Jika pilih "lain-lain"
    if ($request->pekerjaan_pasien === 'lain-lain') {
        $data['pekerjaan_pasien'] = $request->pekerjaan_pasien_lain;
    }

    Patient::create($data);

    return redirect()
        ->route('pendaftaran.form')
        ->with('success', 'Data berhasil dikirim, menunggu validasi admin.');
}

}
