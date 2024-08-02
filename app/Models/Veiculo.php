<?php

namespace App\Models;

use App\Enum\VeiculoTipo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use HasFactory,
        SoftDeletes;

    public $table = 'veiculo';

    public $fillable = [
        'tipo',
        'modelo',
        'marca',
        'chassi',
        'renavam',
        'placa',
        'cor',
        'data_desativacao',
        'agente_id',
        'creator_id',
        'editor_id',
        'deleter_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'tipo' => 'integer',
        'modelo' => 'string',
        'marca' => 'string',
        'chassi' => 'string',
        'renavam' => 'string',
        'placa' => 'string',
        'cor' => 'string',
        'data_desativacao' => 'datetime',
        'agente_id' => 'integer'
    ];

    public static array $rules = [];
   
    protected function tipo(): Attribute
    {
        return Attribute::make(
            get: function (int $value) {
                return [
                    'type' => $value,
                    'name' => match ($value) {
                        VeiculoTipo::Motorcycle->value => __('Motorcycle'),
                        VeiculoTipo::Car->value => __('Car'),
                        default => ''
                    }
                ];
            }
        );
    }

    public function agente(){
        return $this->hasOne(Agente::class,'id','agente_id');
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
