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
            'nama_pasien' => 'required|string',
            'nik' => 'required|numeric|digits:16|unique:patients,nik',
            'no_rme' => 'nullable|string|unique:patients,no_rme',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat_pasien' => 'nullable|string',
            'no_tlp_pasien' => 'nullable|string',
            'status_perkawinan_pasien' => 'nullable|string',
            'agama_pasien' => 'nullable|string',
            'pekerjaan_pasien' => 'nullable|string',
            'pendidikan_pasien' => 'nullable|string',
            'nama_penanggung_jawab' => 'required|string',
            'no_tlp_penanggung_jawab' => 'nullable|string',
            'pekerjaan_penanggung_jawab' => 'nullable|string',
            'hubungan_dengan_pasien' => 'nullable|string',
        ]);

        $data['status_pasien'] = 'pending';
        $data['no_rme'] = Patient::generateNoRme();

        Patient::create($data);

        return redirect()->route('pendaftaran.form')->with('success', 'Data berhasil dikirim, menunggu validasi admin.');
    }
}
