<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory;

    public function KegitanPenilaian()
    {
        return $this->belongsTo(KegiatanPenilaian::class, 'kegiatan');
    }

    public function DetailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class);
    }
}
