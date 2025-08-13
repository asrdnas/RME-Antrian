<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('tenaga_medis')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();

            // Tanggal & Waktu
            $table->date('tanggal')->nullable();
            $table->time('waktu_kedatangan')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();

            // Anamnesa & Pemeriksaan
            $table->text('anamnesa')->nullable();
            $table->text('pemeriksaan')->nullable();

            // Kesadaran
            $table->enum('kesadaran', ['Sadar', 'Tidak Sadar'])->nullable();

            // Pengukuran Fisik
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->decimal('berat_badan', 5, 2)->nullable();  // kg
            $table->integer('sistole')->nullable();            // mmHg
            $table->integer('diastole')->nullable();           // mmHg

            // Resep & Catatan
            $table->text('resep')->nullable();
            $table->text('catatan')->nullable();

            // Pemeriksaan vital
            $table->integer('respiratory_rate')->nullable(); // x/menit
            $table->integer('heart_rate')->nullable();       // bpm

             // Tenaga Medis & Status
            $table->string('tenaga_medis')->nullable();
            $table->enum('status_pulang', ['Pulang', 'Rujuk', 'Rawat Inap'])->nullable();

            // Terapi
            $table->text('terapi')->nullable();

            // Kasus
            $table->enum('kasus_lama_baru', ['Lama', 'Baru'])->nullable();

            // Diagnosa ICD-10
            $table->string('kode_icd10')->nullable();
            $table->string('deskripsi_icd10')->nullable();


            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
