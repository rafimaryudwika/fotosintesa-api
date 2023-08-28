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
        Schema::create('tahap_penilaians', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('nomor');
            $table->foreignUlid('periode')->constrained('periodes');
            $table->string('name');
            $table->string('singkatan');
            $table->string('snakecase_name');
            $table->timestamps();
        });
        Schema::table('pesertas',function (Blueprint $table) {
            $table->foreignUlid('tahap')->constrained('tahap_penilaians');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap_penilaians');
    }
};
