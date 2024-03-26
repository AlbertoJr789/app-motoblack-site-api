<?php

namespace App\Livewire;

use App\Models\Endereco;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AddressFields extends Component
{

    public $required,
           $endereco,
           $cep,
           $logradouro,
           $numero,
           $bairro,
           $complemento,
           $pais,
           $cidade,
           $estado;


    public function mount($required=null,$endereco=null){
        $this->required = $required;
        if($endereco){
          $this->endereco = $endereco;
          $this->cep = $endereco['cep'];
          $this->logradouro = $endereco['logradouro'];
          $this->numero = $endereco['numero'];
          $this->bairro = $endereco['bairro'];
          $this->complemento = $endereco['complemento'];
          $this->pais = $endereco['pais'];
          $this->cidade = $endereco['cidade'];
          $this->estado = $endereco['estado'];
       }else{
           $this->endereco = $this->cep = $this->logradouro = $this->numero = $this->bairro = $this->complemento = $this->pais = $this->estado = $this->cidade = null;
       }
    }

    public function render()
    {
        return view('livewire.address-fields');
    }

    public function updated(){
        if(!$this->endereco){ //fields always required when on address editing mode
            if($this->cep || $this->logradouro || $this->numero || $this->bairro){
                $this->required = true;
            }else{
                $this->required = false;
            }
        }
    }

    public function updatedCep(){
        switch(app()->getLocale()){
            case 'pt_BR': {

                if(strlen($this->cep) == 9){

                    try {
                        $data = json_decode(Endereco::queryCep($this->cep));

                        if(isset($data->erro)) throw new Exception();

                        $this->logradouro = $data->logradouro;
                        $this->bairro = $data->bairro;
                        $this->pais = 'BR';
                        $this->estado = $data->uf;
                        $this->cidade = $data->localidade;
                        $this->updated();
                    } catch (\Throwable $th) {
                        $message = [
                            'icon' => 'error',
                            'title' => __('Error'),
                            'text' => __('Error While Fetching ZIP Code, insert the data manually'),         
                        ];
                        $this->dispatch('alert',$message);
                    }
    
                }else{  
                    $this->logradouro = null;
                    $this->bairro = null;
                    $this->pais = 'BR';
                    $this->estado = null;
                    $this->cidade = null;
                }   
                break;
            }
            default: break;
        }
    }

}
