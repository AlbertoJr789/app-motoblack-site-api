@php
    $agentes = App\Models\Agente::select('agente.id','P.nome as nome')
                        ->join('pessoa as P','P.id','pessoa_id')
                        ->pluck('nome','id');  
@endphp

<div class="grid sm:grid-cols-2 grid-cols-1 sm:gap-6">
    <!-- Agente Id Field -->
    <div wire:ignore>
        {!! Form::label(__('Owner'), __('Owner').':',['class' => "block mx-1 required"]) !!}
        {!! Form::select(__('Owner'), $agentes, null, ['class' => 'input w-full','required' => 'true','wire:model' => 'agente_id','id' => 'agente_id','data-placeholder' => 'Selecione o Agente Dono do Veículo']) !!}
    </div>
    <!-- Tipo Field -->
    <div>
        {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1 required"]) !!}
        {!! Form::select('tipo', ['1' => __('Motorcycle'),'2' => __('Car')],null, ['class' => 'input w-full','required' => 'true','wire:model' => 'tipo' ]) !!}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $("#agente_id").select2()
            Livewire.on('select2',(id)=>{
               $("#agente_id").val(id).trigger('change')   
            })
        })
    </script>
@endpush

<div class="grid sm:grid-cols-2 grid-cols-1 sm:gap-6">
    <!-- Marca Field -->
    <div class="">
        {!! Form::label('marca', 'Marca:',['class' => "block mx-1"]) !!}
        {!! Form::text('marca', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'marca' ]) !!}
    </div>
    <!-- Modelo Field -->
    <div>
        {!! Form::label('modelo', 'Modelo:',['class' => "block mx-1 required"]) !!}
        {!! Form::text('modelo', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'modelo' ]) !!}
    </div>
</div>

<!-- Cor Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        {!! Form::label('cor', 'Cor:',['class' => "block mx-1 required"]) !!}
        {!! Form::color('cor', null, ['class' => 'input','required' => 'true','wire:model' => 'cor' ]) !!}
    </div>
    @if($Veiculo)
    <div class="flex sm:justify-start justify-center sm:my-auto my-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>
    @endif
</div>
