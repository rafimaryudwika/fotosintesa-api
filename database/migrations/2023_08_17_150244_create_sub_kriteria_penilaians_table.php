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
        Schema::create('kriteria_penilaians', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->foreignUlid('kegiatan')->constrained('kegiatan_penilaians');
            $table->string('kode');
            $table->string('snakecase_name');
            $table->float('bobot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_penilaians');
    }
};
