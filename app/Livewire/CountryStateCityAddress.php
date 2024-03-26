<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CountryStateCityAddress extends Component
{

    public $pais,$estado,$cidade,$required,$updateParent=false;
    public $paises,
           $estados,
           $cidades;

    public function mount($endereco=null){
        $this->paises = ['' => '','BR' => '🇧🇷 '.__('Brazil'), 'EN' => '🇺🇸 '. __('United States')];
        $this->estados = $this->cidades = [];
        if(!$endereco){
            $this->pais = Auth::user()->location->countryCode ?? null;
            if($this->pais){
                $this->updateParent = true;
                $this->updatedPais($this->pais);
                $this->estado = 'MG';  
                $this->updatedEstado($this->estado);
                $this->cidade = 'Formiga';
                $this->updatedCidade($this->cidade);
            }
        }else{
            $this->pais = $endereco['pais'];
            $this->estado = $endereco['estado'];
            $this->cidade = $endereco['cidade'];
            
            $this->initEstados();
            $this->initCidades();
        }
        $this->updateParent = true;
    }

    public function render()
    {
        return view('livewire.country-state-city-address');
    }

    public function updatedPais($pais){
        $this->pais = $pais;
        $this->cidades = [];
        $this->initEstados();
        $this->estado = null;
        // if($this->updateParent){
            // $this->dispatch('updatedPaisEstadoCidade',$this->pais,$this->estado,$this->cidade);
        // }
    }

    public function updatedEstado($estado){
        $this->estado = $estado;
        $this->initCidades();
        $this->cidade = null;
        // if($this->updateParent){
            // $this->dispatch('updatedPaisEstadoCidade',$this->pais,$this->estado,$this->cidade);
        // }
    }

    public function updatedCidade($cidade){
        $this->cidade = $cidade;
        // if($this->updateParent)
            // $this->dispatch('updatedPaisEstadoCidade',$this->pais,$this->estado,$this->cidade);
    }

    public function initEstados(){
        $this->estados = [];
        if($this->pais == 'BR'){
            $this->estados = [
                '' => '',
                'MG' => 'Minas Gerais',
                'RJ' => 'Rio de Janeiro',
                'SP' => 'São Paulo',
                'RS' => 'Rio Grande do Sul',
            ];
        }
        if($this->pais == 'EN'){
            $this->estados = [
                '' => '',
                'MA' => 'Massachussets',
                'NY' => 'New York'
            ];
        }
    }

    public function initCidades(){
        $this->cidades = [];
        if($this->pais == 'BR'){
            if($this->estado == 'MG'){
                $this->cidades = [
                    '' => '',
                    'Formiga' => 'Formiga',
                    'Arcos' => 'Arcos',
                ];
            }
        }
    }

}
