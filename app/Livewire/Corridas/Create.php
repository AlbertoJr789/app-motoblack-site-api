<?php

namespace App\Livewire\Corridas;

use App\Models\Corrida;
use App\Repositories\CorridaRepository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Corrida $Corrida;

    //attributes
    public $id,$agente_id,$passageiro_id,$cancelada,$data_finalizada,$nota_passageiro,$nota_agente,$obs_agente,$obs_passageiro,$justificativa_cancelamento,$veiculo_id,$latitude_origem,$longitude_origem,$latitude_destino,$longitude_destino,$rota_gerada,$created_at,$updated_at,$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Corrida = null;
        $this->id = $this->agente_id = $this->passageiro_id = $this->cancelada = $this->data_finalizada = $this->nota_passageiro = $this->nota_agente = $this->obs_agente = $this->obs_passageiro = $this->justificativa_cancelamento = $this->veiculo_id = $this->latitude_origem = $this->longitude_origem = $this->latitude_destino = $this->longitude_destino = $this->rota_gerada = $this->created_at = $this->updated_at = $this->active = null;
    
    }

    public function render()
    {
        return view('corridas.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit(Corrida $corrida)
    {
        $this->Corrida = $corrida;
        $this->id = $corrida->id;$this->agente_id = $corrida->agente_id;$this->passageiro_id = $corrida->passageiro_id;$this->cancelada = $corrida->cancelada;$this->data_finalizada = $corrida->data_finalizada;$this->nota_passageiro = $corrida->nota_passageiro;$this->nota_agente = $corrida->nota_agente;$this->obs_agente = $corrida->obs_agente;$this->obs_passageiro = $corrida->obs_passageiro;$this->justificativa_cancelamento = $corrida->justificativa_cancelamento;$this->veiculo_id = $corrida->veiculo_id;$this->latitude_origem = $corrida->latitude_origem;$this->longitude_origem = $corrida->longitude_origem;$this->latitude_destino = $corrida->latitude_destino;$this->longitude_destino = $corrida->longitude_destino;$this->rota_gerada = $corrida->rota_gerada;$this->created_at = $corrida->created_at;$this->updated_at = $corrida->updated_at;
        $this->active = $corrida->active;
        $this->open = $this->update = true;
        $this->create = false;
    }

    #[On('delete')]
    public function delete($corridas){
        try {
            if(!is_array($corridas))
                $corridas = [$corridas];
            (new CorridaRepository)->deleteMultiple($corridas);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Corrida(s) '.__('deleted successfuly!')
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
    public function restore($corridas){
        try {
            if(!is_array($corridas))
                $corridas = [$corridas];
            (new CorridaRepository)->restoreMultiple($corridas);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Corrida(s) '.__('restored successfuly!')
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
