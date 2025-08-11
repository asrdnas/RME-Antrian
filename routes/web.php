<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

// Halaman Form Skrining
Route::get('/skrining', function () {
    return view('landingpage.landingpage');
})->name('skrining.form');

// Proses Simpan Pasien
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

