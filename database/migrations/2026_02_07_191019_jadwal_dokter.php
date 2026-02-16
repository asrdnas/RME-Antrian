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
        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->id();

            // relasi ke tenaga medis (dokter)
            $table->foreignId('tenaga_medis_id')
                  ->constrained('tenaga_medis')
                  ->onDelete('cascade');

            // hari praktek
            $table->enum('hari', [
                'Senin', 'Selasa', 'Rabu', 
                'Kamis', 'Jumat', 'Sabtu', 'Minggu'
            ]);

            // jam praktek
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // status aktif jadwal
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokter');
    }
};
