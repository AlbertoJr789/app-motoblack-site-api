<?php

namespace App\Livewire;

use App\Livewire\Forms\AddressForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CountryStateCityAddress extends Component
{

    public ?AddressForm $address;

    public $paises,
           $estados,
           $cidades,
           $required;

    public function mount($address=null){
        $this->paises = [''=> '','BR' => '🇧🇷 '.__('Brazil')];
        $this->estados = $this->cidades = [];
        if($address->pais){
            $this->initEstados();
            $this->initCidades();
        }
    }

    public function render()
    {
        return view('livewire.country-state-city-address');
    }

    public function updatedAddressPais($pais){
        $this->address->pais = $pais;
        $this->cidades = [];
        $this->initEstados();
        $this->address->estado = null;
        if(!$this->required){
            $this->JS('
                setTimeout(toggleRequiredAddressFields,300)
            ');
        }
    }

    public function updatedAddressEstado($estado){
        $this->address->estado = $estado;
        $this->initCidades();
        $this->address->cidade = null;
      
    }

    public function updatedAddressCidade($cidade){
        $this->address->cidade = $cidade;
    }

    public function initEstados(){
        $this->estados = [];
        if($this->address->pais == 'BR'){
            $this->estados = [
                '' => '',
                'MG' => 'Minas Gerais',
            ];
        }
    }

    public function initCidades(){
        $this->cidades = [];
        if($this->address->pais == 'BR'){
            if($this->address->estado == 'MG'){
                $this->cidades = [
                    '' => '',
                    'Formiga' => 'Formiga',
                    'Arcos' => 'Arcos',
                ];
            }
        }
    }

}
