<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapPenilaian extends Model
{
    public function Periode()
    {
        return $this->belongsTo(Periode::class, 'periode');
    }

    public function KegiatanPenilaian()
    {
        return $this->hasMany(KegiatanPenilaian::class);
    }
}
