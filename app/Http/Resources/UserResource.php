<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'no_hp' => ('0' .   strval($this->no_hp)),
            'role' => $this->Roles->name,
            'peserta' => ($this->peserta === 0 ? 'false' : 'true'),
        ];
    }
}
