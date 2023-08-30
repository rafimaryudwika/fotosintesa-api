<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KriteriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // $kegiatan = [
        //     'name' => $this->name,
        //     'kode' => $this->kode,
        //     'snakecase' => $this->snakecase_name,
        //     'bobot' => $this->bobot,
        //     'kriteria' => $this->KriteriaPenilaian
        // ];

        $kriteria = [
            'id' => $this->id,
            'nomor' => $this->nomor,
            'name' => $this->name,
            'snakecase_name' => $this->snakecase_name,
            'kode' => $this->kode,
            'bobot' => $this->bobot
        ];
        // return count($this->KriteriaPenilaian) < 2 ? $kegiatan : $ $kegiatan + ['kriteria' => $kriteria ] ;

        return $kriteria;
    }
}
