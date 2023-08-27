<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TahapPenilaianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->nomor,
            'name' => $this->name,
            'inisial' => $this->singkatan,
            'snakecase' => $this->snakecase_name,

        ];
    }
}
