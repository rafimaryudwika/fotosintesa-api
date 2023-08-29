<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanPenilaian extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'id', 'nomor', 'name', 'tahap_penilaian', 'kode', 'snakecase_name', 'bobot'
    ];

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
