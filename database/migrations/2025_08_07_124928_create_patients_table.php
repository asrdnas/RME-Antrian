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

        $table->string('nama_kk'); // tambahan baru
        $table->string('nama_pasien');
        
        $table->string('jenis_kelamin');
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->text('alamat_pasien');
        $table->string('no_tlp_pasien');

        $table->string('pekerjaan_pasien');

        $table->string('nik')->nullable()->unique();
        $table->unsignedBigInteger('no_rme')->unique();


        $table->enum('status_validasi', ['pending', 'approved', 'rejected'])
              ->default('pending');

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
