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
    public $open = false, $create = true, $update = false;

    public ?Teste $Teste = null;
    public $id = null; 
    public $teste;


    public function render()
    {
        return view('testes.create')->with('teste', $this->Teste);
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit(Teste $teste)
    {
    }

    public function submit()
    {
        try {
            if ($this->create) {
                (new TesteRepository)->create($this->except(['open','create','update','id']));
            } else {
                (new TesteRepository)->update($this->except(['open','create','update','id']), $this->id);
            }
        } catch (\Throwable $th) {
            
        }
    }
}
