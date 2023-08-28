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
        Schema::create('bukti_pembayaran_pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('pendaftar_id')->constrained('pendaftars');
            $table->string('kode_pembayaran');
            $table->boolean('sudah_dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pembayaran_pesertas');
    }
};
