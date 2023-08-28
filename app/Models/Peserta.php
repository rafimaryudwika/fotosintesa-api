<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    public function AbsensiPeserta()
    {
        return $this->hasMany(AbsensiPeserta::class);
    }
    public function KelulusanPeserta()
    {
        return $this->hasMany(KelulusanPeserta::class);
    }
    public function DetailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class);
    }

    public function Pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'peserta_id');
    }
    public function TahapPenilaian()
    {
        return $this->belongsTo(TahapPenilaian::class, 'tahap');
    }
    public function BuktiKelulusan()
    {
        return $this->belongsTo(KelulusanPeserta::class, 'bukti_kelulusan');
    }
}
