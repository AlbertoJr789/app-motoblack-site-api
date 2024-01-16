<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{
    public $table = 'Teste';

    public $fillable = [
        'teste'
    ];

    protected $casts = [
        'id' => 'integer',
        'teste' => 'string'
    ];

    public static array $rules = [
        
    ];

    
}
