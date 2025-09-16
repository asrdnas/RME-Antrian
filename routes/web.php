<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

// Halaman Form Skrining
Route::get('/pendaftaran-patient-klinik-tirta-amerta', function () {
    return view('pendaftaran.formulir');
})->name('pendaftaran.form');

// Proses Simpan Pasien
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

Route::get('/', function () {return view('landingpage.landingpage');});