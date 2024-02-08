<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teste extends Model
{
    use SoftDeletes;

    public $table = 'Teste';

    public $fillable = [
        'teste',
        'active',
        'creator_id',
        'editor_id',
        'deleter_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'teste' => 'string'
    ];

    protected $dates = ['created_at','updated_at','deleted_at'];

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
