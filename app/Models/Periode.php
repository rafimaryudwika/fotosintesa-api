<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name', 'alias', 'slogan', 'minimum_bp', 'maksimum_bp', 'tanggal_mulai', 'tanggal_selesai', 'sedang_berlangsung'
    ];

    public function Pendaftar()
    {
        return $this->hasMany(Pendaftar::class);
    }
    public function TahapPenilaian()
    {
        return $this->hasMany(TahapPenilaian::class);
    }
}
