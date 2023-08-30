<?php

namespace App\Traits;

use App\Models\Periode;

trait PeriodeParams
{


    public function GetPeriodData()
    {
        return Periode::query()
        ->where('sedang_berlangsung', true)
        ->first();
    }

    public function GetPeriodeID()
    {
        return $this->GetPeriodData()->id;
    }

    public function GetSyaratPeserta()
    {
        $min_bp = $this->GetPeriodData()->minimum_bp;
        $max_bp = $this->GetPeriodData()->maksimum_bp;

        return [$min_bp . 1, $max_bp . 1, $max_bp . 0];
    }

    public function GetFailedMessage()
    {
        $msg = 'minimal angkatan kuliah yang bisa mendaftar adalah 20' . $this->GetPeriodData()->maksimum_bp . ' S1/D3 dan 20' . $this->GetPeriodData()->minimum_bp . ' S1' ;

        return $msg;
    }

    // public function GetJadwalPendaftaran()
    // {

    // }

    // public function GetJadwalDaftarUlang()
    // {

    // }
}
