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
            'uuid' => $this->uuid,
            'type' => $this->tipo,
            'agent' => new AgenteResource($this->agente),
            'passenger' => new PassageiroResource($this->passageiro),
            'vehicle' => new VeiculoResource($this->veiculo),
            'origin' => new EnderecoResource($this->origin),
            'destiny' => new EnderecoResource($this->destiny),
            'price' => 0.00,
            'agentEvaluation' => $this->nota_passageiro,
            'passengerEvaluation' => $this->nota_agente,
            'whoCancelled' => $this->quem_cancelou,
            'route' => $this->rota_gerada,
            'cancelled' => $this->cancelada,
            'cancellingReason' => $this->justificativa_cancelamento,
            'agentObs' => $this->obs_agente,
            'passengerObs' => $this->obs_passageiro,
            'createdAt' => $this->created_at,
            'finishedAt' => $this->data_finalizada,
        ];
    }
}
