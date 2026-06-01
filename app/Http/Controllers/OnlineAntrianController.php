<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Antrian;
use Illuminate\Http\Request;

class OnlineAntrianController extends Controller
{
    public function index()
    {
        return view('antrian.ambil');
    }

    public function cek(Request $request)
    {
        $request->validate([
            'no_rme' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $patient = Patient::where('no_rme', $request->no_rme)
            ->whereDate('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$patient) {
            return back()->with(
                'error',
                'Data pasien tidak ditemukan. Silakan melakukan pendaftaran terlebih dahulu.'
            );
        }

        if ($patient->status_validasi !== 'approved') {
            return back()->with(
                'error',
                'Data Anda masih menunggu validasi admin. Silakan hubungi klinik terlebih dahulu.'
            );
        }

        return view('antrian.konfirmasi', compact('patient'));
    }

    public function simpan(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);

        $antrianAktif = Antrian::where('patient_id', $patient->id)
            ->where('pelayanan', 'Gilut')
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->whereDate('tanggal', today())
            ->first();

        if ($antrianAktif) {
            return view('antrian.hasil', [
                'antrian' => $antrianAktif,
                'pesan' => 'Anda sudah memiliki antrian aktif hari ini.',
            ]);
        }

        $antrian = Antrian::create([
            'patient_id' => $patient->id,
            'pelayanan' => 'Gilut',
        ]);

        return view('antrian.hasil', [
            'antrian' => $antrian,
            'pesan' => 'Antrian berhasil dibuat.',
        ]);
    }
}