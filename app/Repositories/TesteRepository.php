<?php

namespace App\Repositories;

use App\Models\Teste;
use App\Repositories\BaseRepository;

class TesteRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'teste'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Teste::class;
    }
}
