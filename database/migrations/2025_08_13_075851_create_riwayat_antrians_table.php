<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('riwayat_antrians', function (Blueprint $table) {
            $table->id();
            $table->string('no_antrian');
            $table->string('no_rme')->nullable();
            $table->string('nama_pasien')->nullable();
            $table->string('alamat_pasien')->nullable();
            $table->string('pelayanan');
            $table->string('ruangan')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->dateTime('tanggal_reset'); // kapan direset
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_antrians');

    }
};
