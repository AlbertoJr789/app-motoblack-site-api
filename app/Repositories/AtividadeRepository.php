<?php

namespace App\Repositories;

use App\Models\Atividade;
use App\Repositories\BaseRepository;

class AtividadeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'agente_id',
        'passageiro_id',
        'cancelada',
        'data_finalizada',
        'nota_passageiro',
        'nota_agente',
        'obs_agente',
        'obs_passageiro',
        'justificativa_cancelamento',
        'veiculo_id',
        'latitude_origem',
        'longitude_origem',
        'latitude_destino',
        'longitude_destino',
        'rota_gerada'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Atividade::class;
    }
}
