<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Endereco extends Model
{
    use HasFactory;

    public $table = 'endereco';

    protected $fillable = [
        'latitude',
        'longitude',
        'cep',
        'logradouro',
        'complemento',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'pais'
    ];

    public function getFormattedAddressAttribute(){
        return "$this->logradouro, $this->numero, $this->bairro $this->complemento - $this->cidade/$this->estado - $this->pais - $this->cep";
    }

    public static function queryCep($cep) {
        try {
            return json_decode(preg_replace('/[?();]/','',Http::get("https://viacep.com.br/ws/$cep/json/?callback=?")->body()));
        } catch (\Throwable $th) {
            return null;
        }
    }


}
