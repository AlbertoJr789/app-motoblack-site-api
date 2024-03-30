<?php

namespace App\Repositories;

use App\Models\Passageiro;
use App\Repositories\BaseRepository;

class PassageiroRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'pessoa_id',
        'user_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Passageiro::class;
    }
}
