<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'id', 'nomor', 'name', 'kegiatan', 'kode', 'snakecase_name', 'bobot'
    ];

    public function KegitanPenilaian()
    {
        return $this->belongsTo(KegiatanPenilaian::class, 'kegiatan');
    }

    public function DetailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class);
    }
}
