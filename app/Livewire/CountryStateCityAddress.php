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
        $this->paises = ['BR' => '🇧🇷 '.__('Brazil'), 'EN' => '🇺🇸 '. __('United States')];
        $this->estados = $this->cidades = [];
        if(!$address->pais){
            $this->address->pais = location()->countryCode ?? null;
            if($this->address->pais){
                $this->updatedPais($this->pais);
                $this->address->estado = 'MG';  
                $this->updatedEstado($this->estado);
                $this->address->cidade = 'Formiga';
                $this->updatedCidade($this->cidade);
            }
        }else{
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
                'RJ' => 'Rio de Janeiro',
                'SP' => 'São Paulo',
                'RS' => 'Rio Grande do Sul',
            ];
        }
        if($this->address->pais == 'EN'){
            $this->estados = [
                '' => '',
                'MA' => 'Massachussets',
                'NY' => 'New York'
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
