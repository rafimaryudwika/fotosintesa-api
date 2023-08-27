<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangFakultas extends Model
{
    public function Fakultas()
    {
        return $this->hasMany(Fakultas::class);
    }
}
