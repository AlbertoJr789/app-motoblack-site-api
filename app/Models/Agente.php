<?php

namespace App\Models;

use App\Enum\AgenteTipo;
use App\Enum\VeiculoTipo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\HttpFoundation\FileBag;

class Agente extends Authenticatable

{
    use HasFactory,
        HasApiTokens,
        SoftDeletes;
    public $table = 'agente';

    public $fillable = [
        // 'tipo',
        'uuid',
        'status',
        'latitude',
        'longitude',
        'pessoa_id',
        'user_id',
        'data_desativacao',
        'em_analise',
        'creator_id',
        'editor_id',
        'deleter_id',
        // 'active',
        'veiculo_ativo_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'tipo' => 'integer',
        'status' => 'integer',
        'latitude' => 'string',
        'longitude' => 'string',
        'active' => 'bool',
        'em_analise' => 'bool'
    ];

    public static array $rules = [];

    public function pessoa(){
        return $this->hasOne(Pessoa::class,'id','pessoa_id');
    }

    public function activeVehicle(){
        return $this->hasOne(Veiculo::class,'id','veiculo_ativo_id');
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

    public function getTipoAttribute(){
        return match($this->activeVehicle?->tipo){
            VeiculoTipo::Car => AgenteTipo::Driver,
            VeiculoTipo::Motorcycle =>  AgenteTipo::Pilot,
            default => ''
        };
    }

    public function uploadFiles(FileBag $files){
    
        foreach($files as $key => $file){
            $ext = $file->getClientOriginalExtension();
            if($key === 'vehicle_doc'){
                Storage::disk('vehicle')->put("/$this->veiculo_ativo_id/document.$ext",file_get_contents($file->getRealPath()));
            }else{
                Storage::disk('agent')->put("/$this->id/$key.$ext",file_get_contents($file->getRealPath()));
            }
        }
    }

    public function getDocument($doc){
        $filename = collect(Storage::disk('agent')->files("/$this->id/"))->filter(function($item) use ($doc) { 
            return pathinfo($item,PATHINFO_FILENAME) === $doc;
        })->first();

        if(!$filename) return null;
        return (object) ['content' => Storage::disk('agent')->get($filename), 'mimeType' => Storage::disk('agent')->mimeType($filename) ];
    }


}
