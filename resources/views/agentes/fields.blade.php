<!-- Tipo Field -->
<div class="grid sm:grid-cols-2 grid-cols-1 gap-6">
    {{-- <div>
        {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1"]) !!}
        {!! Form::select('tipo', ['1' => 'Moto Black', '2' => 'Motorista'], null, ['class' => 'input w-full','required' =>
        'true','wire:model' => 'tipo']) !!}
    </div> --}}
    <!-- Status Field -->
    {{-- <div>
        {!! Form::label('status', 'Status:',['class' => "block mx-1"]) !!}
        {!! Form::select('status', ['0' => 'Indisponível', '1' => 'Disponivel', '2' => 'Em Corrida'], null, ['class' =>
        'input w-full','required' => 'true','wire:model' => 'status']) !!}
    </div>
     --}}
    <div class="flex sm:justify-start justify-center sm:my-auto my-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',$active,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>

</div>

<div class="grid sm:grid-cols-2 sm:gap-6 grid-cols-1" x-show="!$wire.active">
    <!-- Documento Field -->
    <div>
        {!! Form::label('motivo_inativo', 'Motivo Inativo:',['class' => "block mx-1 required"]) !!}
        {!! Form::text('motivo_inativo', null, ['class' => 'input w-full','wire:model' => 'motivo_inativo','x-bind:required'=>'!$wire.active']) !!}
    </div>
</div>
