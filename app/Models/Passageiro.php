<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Passageiro extends Authenticatable
{
    use HasFactory,
        HasApiTokens,
        SoftDeletes;

    public $table = 'passageiro';

    public $fillable = [
        'pessoa_id',
        'user_id',
        'creator_id',
        'editor_id',
        'deleter_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'pessoa_id' => 'integer',
        'user_id' => 'integer'
    ];

    public static array $rules = [];

    public function pessoa(){
        return $this->hasOne(Pessoa::class,'id','pessoa_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
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
