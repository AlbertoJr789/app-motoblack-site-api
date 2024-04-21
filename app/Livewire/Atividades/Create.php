<?php

namespace App\Livewire\Atividades;

use App\Models\Atividade;
use App\Repositories\AtividadeRepository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Atividade $Atividade;

    //attributes
    public $id,$agente_id,$passageiro_id,$cancelada,$data_finalizada,$nota_passageiro,$nota_agente,$obs_agente,$obs_passageiro,$justificativa_cancelamento,$veiculo_id,$latitude_origem,$longitude_origem,$latitude_destino,$longitude_destino,$rota_gerada,$created_at,$updated_at,$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Atividade = null;
        $this->id = $this->agente_id = $this->passageiro_id = $this->cancelada = $this->data_finalizada = $this->nota_passageiro = $this->nota_agente = $this->obs_agente = $this->obs_passageiro = $this->justificativa_cancelamento = $this->veiculo_id = $this->latitude_origem = $this->longitude_origem = $this->latitude_destino = $this->longitude_destino = $this->rota_gerada = $this->created_at = $this->updated_at = $this->active = null;
    
    }

    public function render()
    {
        return view('atividades.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit(Atividade $Atividade)
    {
        $this->Atividade = $Atividade;
        $this->id = $Atividade->id;$this->agente_id = $Atividade->agente_id;$this->passageiro_id = $Atividade->passageiro_id;$this->cancelada = $Atividade->cancelada;$this->data_finalizada = $Atividade->data_finalizada;$this->nota_passageiro = $Atividade->nota_passageiro;$this->nota_agente = $Atividade->nota_agente;$this->obs_agente = $Atividade->obs_agente;$this->obs_passageiro = $Atividade->obs_passageiro;$this->justificativa_cancelamento = $Atividade->justificativa_cancelamento;$this->veiculo_id = $Atividade->veiculo_id;$this->latitude_origem = $Atividade->latitude_origem;$this->longitude_origem = $Atividade->longitude_origem;$this->latitude_destino = $Atividade->latitude_destino;$this->longitude_destino = $Atividade->longitude_destino;$this->rota_gerada = $Atividade->rota_gerada;$this->created_at = $Atividade->created_at;$this->updated_at = $Atividade->updated_at;
        $this->active = $Atividade->active;
        $this->open = $this->update = true;
        $this->create = false;
    }

    #[On('delete')]
    public function delete($Atividades){
        try {
            if(!is_array($Atividades))
                $Atividades = [$Atividades];
            (new AtividadeRepository)->deleteMultiple($Atividades);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Atividade(s) '.__('deleted successfuly!')
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
    public function restore($Atividades){
        try {
            if(!is_array($Atividades))
                $Atividades = [$Atividades];
            (new AtividadeRepository)->restoreMultiple($Atividades);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Atividade(s) '.__('restored successfuly!')
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
