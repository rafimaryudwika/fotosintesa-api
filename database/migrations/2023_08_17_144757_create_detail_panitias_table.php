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
        Schema::create('detail_panitias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('panitia_id')->constrained('panitias');
            $table->string('nama_lengkap');
            $table->integer('angkatan');
            $table->integer('nra');
            $table->integer('divisi');
            $table->string('profile_photo');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_panitias');
    }
};
