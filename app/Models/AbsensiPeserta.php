<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPeserta extends Model
{
    use HasFactory;

    public function Peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta');
    }

    public function KegiatanPenilaian()
    {
        return $this->belongsTo(KegiatanPenilaian::class, 'kegiatan');
    }
}
