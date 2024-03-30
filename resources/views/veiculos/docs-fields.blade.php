

<div class="grid sm:grid-cols-2 grid-cols-1">
    <!-- Renavam Field -->
    <div>
        {!! Form::label('renavam', 'Renavam:',['class' => "block mx-1"]) !!}
        {!! Form::text('renavam', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'renavam' ]) !!}
    </div>
    <!-- Chassi Field -->
    <div>
        {!! Form::label('chassi', 'Chassi:',['class' => "block mx-1"]) !!}
        {!! Form::text('chassi', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'chassi' ]) !!}
    </div>
</div>

<div class="grid sm:grid-cols-2 grid-cols-1">
    <!-- Placa Field -->
    <div>
        {!! Form::label('placa', 'Placa:',['class' => "block mx-1"]) !!}
        {!! Form::text('placa', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'placa' ]) !!}
    </div>
</div>
