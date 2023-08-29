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
        Schema::table('periodes', function (Blueprint $table) {
            $table->string('slogan')->nullable(); //slogan kegiatan
            $table->string('name', 10)->change();
            $table->string('alias');
            $table->tinyInteger('minimum_bp');
            $table->tinyInteger('maksimum_bp');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->dropColumn('selesai');
            $table->boolean('sedang_berlangsung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periodes', function (Blueprint $table) {
            $table->dropColumn(['alias', 'slogan', 'minimum_bp', 'maksimum_bp', 'tanggal_mulai', 'tanggal_selesai', 'sedang_berlangsung']);
            $table->boolean('selesai');
            $table->integer('name')->change();
        });
    }
};
