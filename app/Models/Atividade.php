<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    public $table = 'atividade';

    public $dates = ['data_finalizada'];

    public $fillable = [
        'agente_id',
        'uuid',
        'passageiro_id',
        'cancelada',
        'data_finalizada',
        'nota_passageiro',
        'nota_agente',
        'obs_agente',
        'obs_passageiro',
        'justificativa_cancelamento',
        'veiculo_id',
        'tipo',
        'origem',
        'destino',
        'rota_gerada'
    ];

    protected $casts = [
        'id' => 'integer',
        'agente_id' => 'integer',
        'passageiro_id' => 'integer',
        'cancelada' => 'integer',
        'data_finalizada' => 'datetime',
        'nota_passageiro' => 'double',
        'nota_agente' => 'double',
        'obs_agente' => 'string',
        'obs_passageiro' => 'string',
        'justificativa_cancelamento' => 'string',
        'veiculo_id' => 'integer',
        'latitude_origem' => 'string',
        'longitude_origem' => 'string',
        'latitude_destino' => 'string',
        'longitude_destino' => 'string',
        'rota_gerada' => 'string'
    ];

    public static array $rules = [];


    public function origin()
    {
        return $this->hasOne(Endereco::class, 'id', 'origem');
    }

    public function destiny()
    {
        return $this->hasOne(Endereco::class, 'id', 'destino');
    }

    public function veiculo()
    {
        return $this->hasOne(Veiculo::class, 'id', 'veiculo_id');
    }

    public function agente()
    {
        return $this->hasOne(Agente::class, 'id', 'agente_id');
    }

    public function passageiro()
    {
        return $this->hasOne(Passageiro::class, 'id', 'passageiro_id');
    }

    protected function tipo(): Attribute
    {
        return Attribute::make(
            get: function (int $value) {
                return [
                    'tipo' => $value,
                    'nome' => match ($value) {
                        1 => __('Bike Trip'),
                        2 => __('Delivery'),
                        3 => __('Car Trip'),
                        default => ''
                    }
                ];
            }
        );
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function editor()
    {
        return $this->hasOne(User::class, 'id', 'editor_id');
    }

    public function deleter()
    {
        return $this->hasOne(User::class, 'id', 'deleter_id');
    }
}
