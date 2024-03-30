<?php

namespace App\Repositories;

use App\Models\Agente;
use App\Repositories\BaseRepository;

class AgenteRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'tipo',
        'status',
        'latitude',
        'longitude'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Agente::class;
    }
}
