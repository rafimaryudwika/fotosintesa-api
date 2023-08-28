<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanPenilaian extends Model
{
    use HasFactory;

    public function TahapPenilaian()
    {
        return $this->belongsTo(TahapPenilaian::class, 'tahap_penilaian');
    }
    public function KriteriaPenilaian()
    {
        return $this->hasMany(KriteriaPenilaian::class);
    }
    public function AbsensiPeserta()
    {
        return $this->hasMany(AbsensiPeserta::class);
    }
}
