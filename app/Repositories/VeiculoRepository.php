<?php

namespace App\Repositories;

use App\Models\Veiculo;
use App\Repositories\BaseRepository;

class VeiculoRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'tipo',
        'modelo',
        'marca',
        'chassi',
        'renavam',
        'placa',
        'cor',
        'data_desativacao',
        'agente_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Veiculo::class;
    }
}
