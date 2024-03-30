<?php

namespace App\Livewire\Veiculos;

use App\Models\Veiculo;
use App\Repositories\VeiculoRepository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Veiculo $Veiculo;

    //attributes
    public $id,$tipo,$modelo,$marca,$chassi,$renavam,$placa,$cor,$data_desativacao,$agente_id,$created_at,$updated_at,$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Veiculo = null;
        $this->id = $this->tipo = $this->modelo = $this->marca = $this->chassi = $this->renavam = $this->placa = $this->cor = $this->data_desativacao = $this->agente_id = $this->created_at = $this->updated_at = $this->active = null;
    
    }

    public function render()
    {
        return view('veiculos.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit(Veiculo $veiculo)
    {
        $this->Veiculo = $veiculo;
        $this->id = $veiculo->id;$this->tipo = $veiculo->tipo;$this->modelo = $veiculo->modelo;$this->marca = $veiculo->marca;$this->chassi = $veiculo->chassi;$this->renavam = $veiculo->renavam;$this->placa = $veiculo->placa;$this->cor = $veiculo->cor;$this->data_desativacao = $veiculo->data_desativacao;$this->agente_id = $veiculo->agente_id;$this->created_at = $veiculo->created_at;$this->updated_at = $veiculo->updated_at;
        $this->active = $veiculo->active;
        $this->open = $this->update = true;
        $this->create = false;
    }

    #[On('delete')]
    public function delete($veiculos){
        try {
            if(!is_array($veiculos))
                $veiculos = [$veiculos];
            (new VeiculoRepository)->deleteMultiple($veiculos);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Veiculo(s) '.__('deleted successfuly!')
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
    public function restore($veiculos){
        try {
            if(!is_array($veiculos))
                $veiculos = [$veiculos];
            (new VeiculoRepository)->restoreMultiple($veiculos);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Veiculo(s) '.__('restored successfuly!')
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
