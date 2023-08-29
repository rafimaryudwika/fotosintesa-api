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
        Schema::table('kegiatan_penilaians', function (Blueprint $table) {
            $table->integer('nomor')->after('id');
        });
        Schema::table('kriteria_penilaians', function (Blueprint $table) {
            $table->integer('nomor')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatan_penilaians', function (Blueprint $table) {
            $table->dropColumn('nomor');
        });
        Schema::table('kriteria_penilaians', function (Blueprint $table) {
            $table->dropColumn('nomor');
        });
    }
};
