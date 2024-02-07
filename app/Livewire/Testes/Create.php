<?php

namespace App\Livewire\Testes;

use App\Http\Controllers\TesteController;
use App\Http\Requests\CreateTesteRequest;
use App\Models\Teste;
use App\Repositories\TesteRepository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Teste $Teste;

    //attributes
    public $teste;
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Teste = null;
        $teste = null;
    }

    public function render()
    {
        return view('testes.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit(Teste $teste)
    {
        $this->Teste = $teste;
        $this->teste = $teste->teste;
        $this->open = $this->update = true;
        $this->create = false;
    }

    #[On('delete')]
    public function delete($testes){
        try {
            if(!is_array($testes))
                $testes = [$testes];
            (new TesteRepository)->deleteMultiple($testes);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Teste(s) '.__('deleted successfuly!')
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
    public function restore($testes){
        try {
            if(!is_array($testes))
                $testes = [$testes];
            (new TesteRepository)->restoreMultiple($testes);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Teste(s) '.__('restored successfuly!')
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

    public function submit()
    {
        try {
            if ($this->create) {
                (new TesteRepository)->create($this->except(['open','create','update']));
                $message = [
                    'icon' => 'success',
                    'title' => __('Success'),
                    'text' => 'Teste '.__('added successfully!')
                ];
            } else {
                (new TesteRepository)->update($this->except(['open','create','update','id']),$this->Teste->id);
                $message = [
                    'icon' => 'success',
                    'title' => __('Success'),
                    'text' => 'Teste '.__('updated successfully!')
                ];
            }
        } catch (\Throwable $th) {
            $message = [
                'icon' => 'error',
                'title' => __('Error'),
                'text' => __('Whoops! Something went wrong.')
            ];
        }
        $this->open = false;
        $this->dispatch('alert',$message);
    }
}
