<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'no_hp' => $this->no_hp,
            'role' => $this->role,
            'peserta' => $this->peserta,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            // Add other fields as needed
        ];
    }
}
