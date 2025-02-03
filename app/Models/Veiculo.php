<?php

namespace App\Models;

use App\Enum\VeiculoTipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'active',
        'motivo_inativo'
    ];

    protected $casts = [
        'id' => 'integer',
        'tipo' => VeiculoTipo::class,
        'modelo' => 'string',
        'marca' => 'string',
        'chassi' => 'string',
        'renavam' => 'string',
        'placa' => 'string',
        'cor' => 'string',
        'data_desativacao' => 'datetime',
        'agente_id' => 'integer',
        'motivo_inativo' => 'string'
    ];

    public static array $rules = [];

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

    public function uploadDocument($document)
    {
        $ext = $document->getClientOriginalExtension();
        Storage::disk('vehicle')->put("/$this->id/document.$ext",file_get_contents($document->getRealPath()));
    }

}
