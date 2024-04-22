<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AtividadeResource extends JsonResource
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
            'type' => [
                'code' => $this->tipo, 
                'name' => $this->tipoName
            ],
            'creationDate' => $this->created_at,
            'agent' => new AgenteResource($this->agente),
            'passenger' => new PassageiroResource($this->passageiro),
            'vehicle' => new VeiculoResource($this->veiculo),
            'origin' => new EnderecoResource($this->origin),
            'destiny' => new EnderecoResource($this->destiny),
            'price' => 0.0,
            'agentEvaluation' => $this->nota_agente,
            'passengerEvaluation' => $this->nota_passageiro,
            'route' => $this->rota_gerada,
            'canceled' => $this->cancelada,
            'cancellingReason' => $this->justificativa_cancelamento
        ];
    }
}
