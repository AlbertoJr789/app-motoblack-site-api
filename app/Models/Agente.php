<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
class Agente extends Model
{
     use SoftDeletes;    public $table = 'agente';

    public $fillable = [
        'tipo',
        'status',
        'latitude',
        'longitude',
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
