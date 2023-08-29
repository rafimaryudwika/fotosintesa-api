<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapPenilaian extends Model
{
    use HasUlids;
    protected $fillable = [
        'nomor', 'name', 'singkatan', 'periode', 'snakecase_name'
    ];
    public function Periode()
    {
        return $this->belongsTo(Periode::class, 'periode');
    }

    public function KegiatanPenilaian()
    {
        return $this->hasMany(KegiatanPenilaian::class);
    }
}
