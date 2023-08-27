<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    public function BidangFakultas()
    {
        return $this->belongsTo(BidangFakultas::class, 'bidang_fakultas_id');
    }
    public function Jurusan()
    {
        return $this->hasMany(Jurusan::class);
    }
}
