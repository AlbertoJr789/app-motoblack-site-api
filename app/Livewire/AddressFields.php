<?php

namespace App\Livewire;

use App\Livewire\Forms\AddressForm;
use App\Models\Endereco;
use Exception;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AddressFields extends Component
{

    public $required;
    public ?AddressForm $address;

    public function mount($required=null,$addr=null){
        $this->required = $required;
        if($addr){
          $this->address->cep = $addr['cep'];
          $this->address->logradouro = $addr['logradouro'];
          $this->address->numero = $addr['numero'];
          $this->address->bairro = $addr['bairro'];
          $this->address->complemento = $addr['complemento'];
          $this->address->pais = $addr['pais'];
          $this->address->cidade = $addr['cidade'];
          $this->address->estado = $addr['estado'];
        }
    }

    public function render()
    {
        return view('livewire.address-fields');
    }

    public function updatedAddressCep(){
        switch(app()->getLocale()){
            case 'pt_BR': {

                if(strlen($this->address->cep) == 9){

                    try {
                        $data = Endereco::queryCep($this->address->cep);

                        if(isset($data->erro)) throw new Exception();

                        $this->address->logradouro = $data->logradouro;
                        $this->address->bairro = $data->bairro;
                        $this->address->pais = 'BR';
                        $this->address->estado = $data->uf;
                        $this->address->cidade = $data->localidade;
                        
                    } catch (\Throwable $th) {
                        $message = [
                            'icon' => 'error',
                            'title' => __('Error'),
                            'text' => __('Error While Fetching ZIP Code, insert the data manually'),         
                        ];
                        $this->dispatch('alert',$message);
                    }
    
                }
                break;
            }
            default: break;
        }
    }

}
