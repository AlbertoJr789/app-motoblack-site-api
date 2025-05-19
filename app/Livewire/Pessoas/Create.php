<?php

namespace App\Livewire\Pessoas;

use App\Models\Endereco;
use App\Models\Pessoa;
use App\Repositories\PessoaRepository;
use App\Rules\DocumentRule;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Pessoa $Pessoa; 
    public $showActive = false;
    public $endereco;

    //attributes
    public $id,$nome,$tipo=1,$documento,$rg,$active;


    public function mount(){
        $this->open = $this->create = $this->update = false;
        $this->Pessoa = $this->endereco = null;
        $this->id = $this->nome = $this->documento = $this->rg = $this->active = null;
        $this->tipo = 1;
    }

    public function render()
    {
   
        return view('pessoas.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
        $this->showActive = false;

        $this->dispatch('resetStepper');
    }

    #[On('openEdit')]
    public function openEdit(Pessoa $pessoa)
    {

        $this->Pessoa = $pessoa;

        $this->id = $pessoa->id;
        $this->nome = $pessoa->nome;
        $this->tipo = $pessoa->tipo;
        $this->documento = $pessoa->documento;
        $this->rg = $pessoa->rg;
        
        $this->active = $pessoa->active;
        $this->open = $this->update = true;
        $this->create = false;

        $this->showActive = true;
        
        if($pessoa->endereco){
            $this->endereco = $pessoa->endereco->toArray();
        }else{
            $this->endereco = null;
        }
        $this->dispatch('resetStepper');
    }

    #[On('delete')]
    public function delete($pessoas){
        try {
            if(!is_array($pessoas))
                $pessoas = [$pessoas];
            (new PessoaRepository)->deleteMultiple($pessoas);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Pessoa(s) '.__('deleted successfuly!')
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
    public function restore($pessoas){
        try {
            if(!is_array($pessoas))
                $pessoas = [$pessoas];
            (new PessoaRepository)->restoreMultiple($pessoas);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Pessoa(s) '.__('restored successfuly!')
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
