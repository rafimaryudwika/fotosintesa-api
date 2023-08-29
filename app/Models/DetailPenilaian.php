<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    public function Peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta');
    }

    public function KriteriaPenilaian()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria');
    }
}
