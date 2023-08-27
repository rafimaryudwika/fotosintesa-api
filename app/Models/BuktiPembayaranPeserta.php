<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPembayaranPeserta extends Model
{
    public function Pendaftar() {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}
