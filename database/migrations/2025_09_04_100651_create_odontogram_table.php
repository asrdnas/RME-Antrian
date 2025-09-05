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
        Schema::create('odontogram', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained()->cascadeOnDelete();
            $table->string('kode_gigi'); // misal 11, 21, 36, dll
            $table->string('kondisi')->nullable(); // sehat, karies, dll
            $table->string('diagnosa_icd')->nullable();
            $table->string('tindakan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontogram');
    }
};
