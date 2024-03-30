<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
class Corrida extends Model
{
     use SoftDeletes;    public $table = 'corrida';

    public $fillable = [
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
        'rota_gerada',
        'creator_id',
        'editor_id',
        'deleter_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'agente_id' => 'integer',
        'passageiro_id' => 'integer',
        'cancelada' => 'integer',
        'data_finalizada' => 'datetime',
        'nota_passageiro' => 'integer',
        'nota_agente' => 'integer',
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

    public static array $rules = [
        
    ];

    

    public function creator(){
        return $this->hasOne(User::class,'id','creator_id');
    }

    public function editor(){
        return $this->hasOne(User::class,'id','editor_id');
    }

    public function deleter(){
        return $this->hasOne(User::class,'id','deleter_id');
    }

}
