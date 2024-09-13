<?php

namespace App\Livewire\Agentes;

use App\Models\Agente;
use App\Repositories\AgenteRepository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Agente $Agente;

    //attributes
    public $id,$tipo,$status,$latitude,$longitude,$created_at,$updated_at,$em_analise,$veiculo_ativo_id,$motivo_inativo,$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Agente = null;
        $this->id = $this->tipo = $this->status = $this->latitude = $this->longitude 
        = $this->created_at = $this->updated_at = $this->motivo_inativo = 
        $this->active = $this->veiculo_ativo_id = $this->em_analise = null;    
    }

    public function render()
    {
        return view('agentes.create');
    }

    #[On('openEdit')]
    public function openEdit(Agente $agente)
    {
        $this->Agente = $agente;
        $this->id = $agente->id;
        $this->tipo = $agente->tipo;
        $this->status = $agente->status;
        $this->active = $agente->active;
        $this->veiculo_ativo_id = $agente->veiculo_ativo_id;
        $this->motivo_inativo = $agente->motivo_inativo;
        $this->em_analise = $agente->em_analise;
        $this->open = $this->update = true;
        $this->create = false;
        $this->dispatch('resetStepper');
    }

    #[On('delete')]
    public function delete($agentes){
        try {
            if(!is_array($agentes))
                $agentes = [$agentes];
            (new AgenteRepository)->deleteMultiple($agentes);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Agente(s) '.__('deleted successfuly!')
            ];
        } catch (\Throwable $th) {
            $message = [
                'icon' => 'error',
                'title' => __('Error'),
                'text' => __('Whoops! Something went wrong.')
            ];
        }
        $this->dispatch('alert',$message);
    }

    #[On('restore')]
    public function restore($agentes){
        try {
            if(!is_array($agentes))
                $agentes = [$agentes];
            (new AgenteRepository)->restoreMultiple($agentes);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Agente(s) '.__('restored successfuly!')
            ];
        } catch (\Throwable $th) {
            $message = [
                'icon' => 'error',
                'title' => __('Error'),
                'text' => __('Whoops! Something went wrong.')
            ];
        }
        $this->dispatch('alert',$message);
    }
}
