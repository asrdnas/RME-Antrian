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
        Schema::create('layanan_kliniks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('navbar_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('tag');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_kliniks');
    }
};
