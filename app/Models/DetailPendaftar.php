<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPendaftar extends Model
{
    public function Gender()
    {
        return $this->belongsTo(JenisKelamin::class, 'gender_id',);
    }

    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id',);
    }

    public function Pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}
