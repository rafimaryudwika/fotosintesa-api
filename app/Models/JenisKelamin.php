<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKelamin extends Model
{
    public function Pendaftar()
    {
        return $this->hasMany(DetailPendaftar::class, 'id');
    }
}
