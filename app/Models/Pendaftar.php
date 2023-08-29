<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    public function DetailPendaftar()
    {
        return $this->hasOne(DetailPendaftar::class);
    }

    public function BuktiPembayaran()
    {
        return $this->hasMany(BuktiPembayaranPeserta::class);
    }

    public function Peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    public function Periode()
    {
        return $this->belongsTo(Periode::class, 'periode');
    }

    public function UserID()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
