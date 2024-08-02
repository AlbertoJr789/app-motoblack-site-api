<!-- Tipo Field -->
<div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
    {{-- <div>
        {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1"]) !!}
        {!! Form::select('tipo', ['1' => 'Moto Black', '2' => 'Motorista'], null, ['class' => 'input w-full','required' =>
        'true','wire:model' => 'tipo']) !!}
    </div> --}}
    <!-- Status Field -->
    <div>
        {!! Form::label('status', 'Status:',['class' => "block mx-1"]) !!}
        {!! Form::select('status', ['0' => 'Indisponível', '1' => 'Disponivel', '2' => 'Em Corrida'], null, ['class' =>
        'input w-full','required' => 'true','wire:model' => 'status']) !!}
    </div>
    
    @if($Agente)
    <div class="flex sm:justify-start justify-center sm:my-auto my-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>
    @endif
</div>