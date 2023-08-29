<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelulusanPeserta extends Model
{
    use HasFactory;

    public function Peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta');
    }

    public function BuktiKelulusan()
    {
        return $this->hasOne(Peserta::class);
    }
}
