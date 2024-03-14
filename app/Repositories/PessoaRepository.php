<?php

namespace App\Repositories;

use App\Models\Pessoa;
use App\Repositories\BaseRepository;

class PessoaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nome',
        'tipo',
        'documento',
        'rg'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Pessoa::class;
    }
}
