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
        Schema::create('periodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('name'); //tahun periode kegiatan
            $table->boolean('selesai'); //apakah pelaksanaan kegiatan fotosintesa sudah selesai
            $table->timestamps();
        });

        Schema::table('pendaftars', function (Blueprint $table) {
            $table->foreignId('periode')->constrained('periodes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn('periode');
        });

        Schema::dropIfExists('periodes');
    }
};
