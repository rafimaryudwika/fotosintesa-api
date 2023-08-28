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
        Schema::create('detail_pendaftars', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('pendaftar_id')->constrained('pendaftars');
            $table->string('panggilan');
            $table->foreignId('gender_id')->constrained('jenis_kelamins');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->foreignId('jurusan_id')->constrained('jurusans');
            $table->integer('provinsi_asal');
            $table->integer('kab_kota_asal');
            $table->integer('kecamatan_asal');
            $table->integer('kelurahan_nagari_asal');
            $table->string('alamat_pdg');
            $table->integer('kelurahan_pdg');
            $table->integer('kecamatan_pdg');
            $table->integer('kota_tempat_tinggal'); //in case kalau ada yang tinggalnya di Padang Pariaman terutama yang tidak ngekos dan tinggal di Kasang dan Katapiang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pendaftars');
    }
};
