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
        Schema::create('setting_infos', function (Blueprint $table) {
            $table->id();

            // Kolom untuk informasi klinik 
            $table->string('judul_klinik1');
            $table->string('judul_highlight1');
            $table->string('judul_klinik2');
            $table->string('judul_highlight2');
            $table->text('deskripsi_klinik');
            $table->string('foto_founder')->nullable();
            $table->string('nama_founder');
            $table->string('jabatan_founder');
            $table->timestamps();

            // Kolom untuk informasi kontak
            $table->string('nomor_whatsapp');

            // Kolom untuk informasi lokasi
            $table->text('alamat');
            $table->string('hari_operasional');
            $table->string('jam_operasional');
            $table->longText('embed_maps')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_infos');
    }
};
