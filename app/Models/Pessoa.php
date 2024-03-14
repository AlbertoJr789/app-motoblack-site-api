<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
class Pessoa extends Model
{
     use SoftDeletes;    public $table = 'pessoa';

    public $fillable = [
        'nome',
        'tipo',
        'documento',
        'rg',
        'creator_id',
        'editor_id',
        'deleter_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'tipo' => 'integer',
        'documento' => 'string',
        'rg' => 'string'
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
