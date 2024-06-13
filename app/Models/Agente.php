<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Agente extends Authenticatable

{
    use HasFactory,
        HasApiTokens,
        SoftDeletes;
    public $table = 'agente';

    public $fillable = [
        'tipo',
        'status',
        'latitude',
        'longitude',
        'pessoa_id',
        'user_id',
        'data_desativacao',
        'creator_id',
        'editor_id',
        'deleter_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'tipo' => 'integer',
        'status' => 'integer',
        'latitude' => 'string',
        'longitude' => 'string'
    ];

    public static array $rules = [];

    protected function tipo(): Attribute
    {
        return Attribute::make(
            get: function (int $value) {
                return [
                    'tipo' => $value,
                    'nome' => match ($value) {
                        1 => __('Motorcycle Pilot'),
                        2 => __('Car Driver'),
                        default => ''
                    }
                ];
            }
        );
    }

    public function pessoa(){
        return $this->hasOne(Pessoa::class,'id','pessoa_id');
    }

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class, 'agente_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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
