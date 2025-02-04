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
            'id' => $this->id,
            'type' => $this->tipo,
            'model' => $this->modelo,
            'brand' => $this->marca,
            'currentActiveVehicle' => $this->agente->veiculo_ativo_id == $this->id ? true : false,
            'inactiveReason' => $this->motivo_inativo,
            //private documents regarding the vehicle will only appear to the owner
            'chassi' => Auth::user() instanceof Agente && Auth::user()->id == $this->agente_id ? $this->chassi : null, 
            'renavam' => Auth::user() instanceof Agente && Auth::user()->id == $this->agente_id  ? $this->renavam : null,
            'plate' => $this->placa,
            'color' => $this->cor,
        ];
    }
}
