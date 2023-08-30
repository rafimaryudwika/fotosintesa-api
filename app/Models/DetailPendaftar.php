<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPendaftar extends Model
{
    protected $fillable = [
        'id',
        'pendaftar_id',
        'panggilan',
        'gender_id',
        'tempat_lahir',
        'tgl_lahir',
        'jurusan_id',
        'provinsi_asal',
        'kab_kota_asal',
        'kecamatan_asal',
        'kelurahan_nagari_asal',
        'alamat_pdg',
        'kelurahan_pdg',
        'kecamatan_pdg',
        'kota_tempat_tinggal'
    ];

    public function Gender()
    {
        return $this->belongsTo(JenisKelamin::class, 'gender_id',);
    }

    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id',);
    }

    public function Pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}
