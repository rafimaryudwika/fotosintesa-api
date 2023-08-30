<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleKriteriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'nomor' => $this->nomor,
            'name' => $this->name,
            'snakecase_name' => $this->snakecase_name,
            'kode' => $this->kode,
            'kegiatan' => $this->KegiatanPenilaian->name,
            'tahap' => $this->KegiatanPenilaian->TahapPenilaian->name,
            'bobot' => $this->bobot
        ];
    }
}
