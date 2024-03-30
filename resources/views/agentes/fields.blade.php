<!-- Tipo Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1"]) !!}
            {!! Form::select('tipo', ['MotoBlack' => 'MotoBlack', 'Uber' => '2'], null, ['class' => 'input','required' => 'true','wire:model' => 'tipo']) !!}
</div>
</div>

<!-- Status Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('status', 'Status:',['class' => "block mx-1"]) !!}
            {!! Form::select('status', ['Indisponível' => 'Indisponível', 'Disponivel' => '1', 'EmCorrida' => '2'], null, ['class' => 'input','required' => 'true','wire:model' => 'status']) !!}
</div>
</div>

<!-- Latitude Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('latitude', 'Latitude:',['class' => "block mx-1"]) !!}
            {!! Form::text('latitude', null, ['class' => 'input','required' => 'true','wire:model' => 'latitude' ]) !!}
</div>
</div>

<!-- Longitude Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('longitude', 'Longitude:',['class' => "block mx-1"]) !!}
            {!! Form::text('longitude', null, ['class' => 'input','required' => 'true','wire:model' => 'longitude' ]) !!}
</div>
</div>

@if($Agente)
        <div class="flex sm:justify-start justify-center sm:my-auto my-4">
            {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
            {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
        </div>
        @endif
    