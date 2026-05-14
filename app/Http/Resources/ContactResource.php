<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'firstName'  => $this->first_name,
            'lastName'   => $this->last_name,
            'phone'      => $this->phone,
            'email'      => $this->email,
            'question'   => $this->question,
            'consent1'   => $this->consent1,
            'consent2'   => $this->consent2,
            'createdAt'  => $this->created_at?->toISOString(),
            'updatedAt'  => $this->updated_at?->toISOString(),
        ];
    }
}
