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
        'criou',
        'editou',
        'deletou'
    ];

    protected $casts = [
        'id' => 'integer',
        'teste' => 'string'
    ];

    public static array $rules = [
        
    ];

    
}
