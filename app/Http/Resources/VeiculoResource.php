<?php

namespace App\Http\Resources;

use App\Models\Agente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class VeiculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->tipo,
            'model' => $this->modelo,
            'brand' => $this->marca,
            //private documents regarding the vehicle will only appear to the owner
            'chassi' => Auth::user()->id == $this->agente_id && Auth::user() instanceof Agente ? $this->chassi : null, 
            'renavam' => Auth::user()->id == $this->agente_id && Auth::user() instanceof Agente ? $this->renavam : null,
            'plate' => $this->placa,
            'color' => $this->cor,
        ];
    }
}
