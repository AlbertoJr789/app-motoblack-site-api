<?php

namespace App\Livewire\Testes;

use Livewire\Component;
use Livewire\Attributes\On;

class Filter extends Component
{

    //screen attributes
    public $open;
    
    public function mount(){
        $this->open = false;
    }

    public function render()
    {
        return view('testes.filter');
    }

    #[On('openFilter')]
    public function openFilter()
    {
        $this->reset();
        $this->open = true;
    }

    public function resetFields(){
        $this->dispatch('resetFilter');
    }

    public function updated(){
        $this->dispatch('filter');
    }

}
