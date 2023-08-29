<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    public function Fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id',);
    }
    public function DetailPendaftar()
    {
        return $this->hasMany(DetailPendaftar::class);
    }
}
