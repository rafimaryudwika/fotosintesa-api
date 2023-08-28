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
        Schema::create('kelulusan_pesertas', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('peserta')->constrained('pesertas')->nullable();
            $table->boolean('lulus')->nullable();
            $table->timestamps();
        });

        Schema::table('pesertas',function (Blueprint $table) {
            $table->foreignUlid('bukti_kelulusan')->constrained('kelulusan_pesertas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelulusan_pesertas');
    }
};
