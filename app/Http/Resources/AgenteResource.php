<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenteResource extends JsonResource
{


    public function __construct(
        public $resource,
        public bool $withVehicle = false
    ){}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->pessoa->nome,
            'user_id' => $this->user_id,
            'rate' => $this->relationLoaded('rate') && $this->rate->isNotEmpty() ? $this->rate->first()->rate : null,
            // 'type' => $this->tipo,
            'avatar' => str_contains($this->user->profile_photo_url, 'ui-avatars') ? null : $this->user->profile_photo_url,
            'vehicle' => $this->withVehicle ? new VeiculoResource($this->activeVehicle) : null
        ];
    }
}
