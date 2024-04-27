<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'zipCode' => $this->cep,
            'street' => $this->logradouro,
            'number' => $this->numero,
            'neighborhood' => $this->bairro,
            'complement' => $this->complemento,
            'country' => $this->pais,
            'state' => $this->state,
            'city' => $this->city,
        ];
    }
}
