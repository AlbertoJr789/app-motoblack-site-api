<?php

namespace App\Livewire\Passageiros;

use App\Models\Passageiro;
use App\Repositories\PassageiroRepository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Passageiro $Passageiro;

    //attributes
    public $id,$pessoa_id,$user_id,$created_at,$updated_at,$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Passageiro = null;
        $this->id = $this->pessoa_id = $this->user_id = $this->created_at = $this->updated_at = $this->active = null;
    
    }

    public function render()
    {
        return view('passageiros.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit(Passageiro $passageiro)
    {
        $this->Passageiro = $passageiro;
        $this->id = $passageiro->id;$this->pessoa_id = $passageiro->pessoa_id;$this->user_id = $passageiro->user_id;$this->created_at = $passageiro->created_at;$this->updated_at = $passageiro->updated_at;
        $this->active = $passageiro->active;
        $this->open = $this->update = true;
        $this->create = false;
    }

    #[On('delete')]
    public function delete($passageiros){
        try {
            if(!is_array($passageiros))
                $passageiros = [$passageiros];
            (new PassageiroRepository)->deleteMultiple($passageiros);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Passageiro(s) '.__('deleted successfuly!')
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
    public function restore($passageiros){
        try {
            if(!is_array($passageiros))
                $passageiros = [$passageiros];
            (new PassageiroRepository)->restoreMultiple($passageiros);
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => 'Passageiro(s) '.__('restored successfuly!')
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
