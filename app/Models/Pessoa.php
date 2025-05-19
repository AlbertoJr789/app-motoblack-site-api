<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory,
        SoftDeletes;

    public $table = 'pessoa';

    public $fillable = [
        'nome',
        'tipo',
        'documento',
        'rg',
        'creator_id',
        'editor_id',
        'deleter_id',
        'endereco_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'tipo' => 'integer',
        'documento' => 'string',
        'rg' => 'string',
        'active' => 'bool'
    ];

    public static array $rules = [];

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

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id', 'endereco_id');
    }

    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id', 'pessoa_id');
    }

    public function passageiro()
    {
        return $this->belongsTo(Passageiro::class, 'id', 'pessoa_id');
    }

}
