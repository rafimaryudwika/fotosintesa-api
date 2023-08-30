<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KegiatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'nomor' => $this->nomor,
            'name' => $this->name,
            'snakecase' => $this->snakecase_name,
            'kode' => $this->kode,
            'bobot' => $this->bobot,
            'jumlah_kriteria' => count($this->KriteriaPenilaian),
            'kriteria' => KriteriaResource::collection($this->KriteriaPenilaian)
        ];
    }
}
