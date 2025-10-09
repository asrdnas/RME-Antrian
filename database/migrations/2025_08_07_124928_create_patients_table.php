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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('nik')->unique();
            $table->string('no_rme')->unique();

            // Pisahkan tempat dan tanggal lahir
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->text('alamat_pasien');
            $table->string('no_tlp_pasien')->nullable();

            $table->string('status_perkawinan_pasien')->nullable();
            $table->string('agama_pasien')->nullable();
            $table->string('pekerjaan_pasien')->nullable();
            $table->string('pendidikan_pasien')->nullable();
            $table->string('status_pasien')->nullable();

            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('no_tlp_penanggung_jawab')->nullable();
            $table->string('pekerjaan_penanggung_jawab')->nullable();
            $table->string('hubungan_dengan_pasien')->nullable();

            $table->enum('status_validasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedInteger('total_kunjungan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
