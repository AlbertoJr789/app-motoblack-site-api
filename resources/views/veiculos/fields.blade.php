@php
    $agentes = App\Models\Agente::select('agente.id','P.nome as nome')
                        ->join('pessoa as P','P.id','pessoa_id')
                        ->where('agente.active',true)
                        ->pluck('id','nome')
                        ->prepend('','');  
@endphp

<div class="grid sm:grid-cols-2 grid-cols-1 sm:gap-6">
    <!-- Agente Id Field -->
    <div>
        {!! Form::label(__('Owner'), __('Owner').':',['class' => "block mx-1"]) !!}
        {!! Form::select(__('Owner'), $agentes, null, ['class' => 'input w-full','required' => 'true','wire:model' => 'agente_id','placeholder' => 'Selecione o Agente Dono do Veículo']) !!}
    </div>
    <!-- Tipo Field -->
    <div>
        {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1"]) !!}
        {!! Form::text('tipo', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'tipo' ]) !!}
    </div>

</div>

<div class="grid sm:grid-cols-2 grid-cols-1 sm:gap-6">
    <!-- Marca Field -->
    <div class="">
        {!! Form::label('marca', 'Marca:',['class' => "block mx-1"]) !!}
        {!! Form::text('marca', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'marca' ]) !!}
    </div>
    <!-- Modelo Field -->
    <div>
        {!! Form::label('modelo', 'Modelo:',['class' => "block mx-1"]) !!}
        {!! Form::text('modelo', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'modelo' ]) !!}
    </div>
</div>

<!-- Cor Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        {!! Form::label('cor', 'Cor:',['class' => "block mx-1"]) !!}
        {!! Form::text('cor', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'cor' ]) !!}
    </div>
</div>

@if($Veiculo)
<div class="flex sm:justify-start justify-center sm:my-auto my-4">
    {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
    {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
</div>
@endif