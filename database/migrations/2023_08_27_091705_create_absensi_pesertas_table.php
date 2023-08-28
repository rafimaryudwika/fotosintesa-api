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
        Schema::create('absensi_pesertas', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('peserta')->constrained('pesertas');
            $table->foreignUlid('kegiatan')->constrained('kegiatan_penilaians');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_pesertas');
    }
};
