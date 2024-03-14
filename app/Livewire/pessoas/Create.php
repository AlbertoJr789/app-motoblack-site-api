<?php

namespace App\Livewire\Pessoas;

use App\Models\Pessoa;
use App\Repositories\PessoaRepository;
use App\Rules\DocumentRule;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?Pessoa $Pessoa;

    //attributes
    public $id,$nome,$tipo=1,$documento,$rg,$created_at,$updated_at,$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        $Pessoa = null;
        $this->id = $this->nome = $this->documento = $this->rg = $this->created_at = $this->updated_at = $this->active = null;
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

    #[On('tipoChanged')]
    public function tipoChanged($doc){
        $this->documento = $doc;
    }

    public function submit()
    {
        try {

            $validator = Validator::make($this->except(['open','create','update','active']),[
                'documento' => new DocumentRule($this->tipo)
            ]);

            if($validator->fails()){
                throw new ValidationException($validator,$validator->errors());
            }

            if ($this->create) {
                (new PessoaRepository)->create($this->except(['open','create','update','active']));
                $message = [
                    'icon' => 'success',
                    'title' => __('Success'),
                    'text' => 'Pessoa '.__('added successfully!')
                ];
            } else {
                (new PessoaRepository)->update($this->except(['open','create','update','id']),$this->Pessoa->id);
                $message = [
                    'icon' => 'success',
                    'title' => __('Success'),
                    'text' => 'Pessoa '.__('updated successfully!')
                ];
            }
            $this->open = false;
        } catch (ValidationException $ex) {
            $message = [
                'icon' => 'warning',
                'title' => __('Warning!'),
                'text' => implode(',',Arr::flatten($ex->errors()))
            ];
        }
        catch (\Throwable $th) {
            \Log::error('Error while submiting Pessoa: '.$th->getMessage());
            $message = [
                'icon' => 'error',
                'title' => __('Error'),
                'text' => __('Whoops! Something went wrong.')
            ];
            $this->open = false;
        }
        $this->dispatch('alert',$message);
    }
}
