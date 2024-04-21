{{-- <!-- Agente Id Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('agente_id', 'Agente Id:',['class' => "block mx-1"]) !!}
            {!! Form::text('agente_id', null, ['class' => 'input','required' => 'true','wire:model' => 'agente_id' ]) !!}
</div>
</div>

<!-- Passageiro Id Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('passageiro_id', 'Passageiro Id:',['class' => "block mx-1"]) !!}
            {!! Form::text('passageiro_id', null, ['class' => 'input','required' => 'true','wire:model' => 'passageiro_id' ]) !!}
</div>
</div>

<!-- Data Finalizada Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('data_finalizada', 'Data Finalizada:',['class' => "block mx-1"]) !!}
            {!! Form::text('data_finalizada', null, ['class' => 'input','required' => 'true','wire:model' => 'data_finalizada' ]) !!}
</div>
</div>

<!-- Nota Passageiro Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('nota_passageiro', 'Nota Passageiro:',['class' => "block mx-1"]) !!}
            {!! Form::text('nota_passageiro', null, ['class' => 'input','required' => 'true','wire:model' => 'nota_passageiro' ]) !!}
</div>
</div>

<!-- Nota Agente Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('nota_agente', 'Nota Agente:',['class' => "block mx-1"]) !!}
            {!! Form::text('nota_agente', null, ['class' => 'input','required' => 'true','wire:model' => 'nota_agente' ]) !!}
</div>
</div>

<!-- Obs Agente Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('obs_agente', 'Obs Agente:',['class' => "block mx-1"]) !!}
            {!! Form::text('obs_agente', null, ['class' => 'input','required' => 'true','wire:model' => 'obs_agente' ]) !!}
</div>
</div>

<!-- Obs Passageiro Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('obs_passageiro', 'Obs Passageiro:',['class' => "block mx-1"]) !!}
            {!! Form::text('obs_passageiro', null, ['class' => 'input','required' => 'true','wire:model' => 'obs_passageiro' ]) !!}
</div>
</div>

<!-- Justificativa Cancelamento Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('justificativa_cancelamento', 'Justificativa Cancelamento:',['class' => "block mx-1"]) !!}
            {!! Form::text('justificativa_cancelamento', null, ['class' => 'input','required' => 'true','wire:model' => 'justificativa_cancelamento' ]) !!}
</div>
</div>

<!-- Veiculo Id Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('veiculo_id', 'Veiculo Id:',['class' => "block mx-1"]) !!}
            {!! Form::text('veiculo_id', null, ['class' => 'input','required' => 'true','wire:model' => 'veiculo_id' ]) !!}
</div>
</div>

<!-- Latitude Origem Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('latitude_origem', 'Latitude Origem:',['class' => "block mx-1"]) !!}
            {!! Form::text('latitude_origem', null, ['class' => 'input','required' => 'true','wire:model' => 'latitude_origem' ]) !!}
</div>
</div>

<!-- Longitude Origem Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('longitude_origem', 'Longitude Origem:',['class' => "block mx-1"]) !!}
            {!! Form::text('longitude_origem', null, ['class' => 'input','required' => 'true','wire:model' => 'longitude_origem' ]) !!}
</div>
</div>

<!-- Latitude Destino Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('latitude_destino', 'Latitude Destino:',['class' => "block mx-1"]) !!}
            {!! Form::text('latitude_destino', null, ['class' => 'input','required' => 'true','wire:model' => 'latitude_destino' ]) !!}
</div>
</div>

<!-- Longitude Destino Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('longitude_destino', 'Longitude Destino:',['class' => "block mx-1"]) !!}
            {!! Form::text('longitude_destino', null, ['class' => 'input','required' => 'true','wire:model' => 'longitude_destino' ]) !!}
</div>
</div>

<!-- Rota Gerada Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('rota_gerada', 'Rota Gerada:',['class' => "block mx-1"]) !!}
            {!! Form::text('rota_gerada', null, ['class' => 'input','required' => 'true','wire:model' => 'rota_gerada' ]) !!}
</div>
</div>

@if($Corrida)
        <div class="flex sm:justify-start justify-center sm:my-auto my-4">
            {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
            {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
        </div>
        @endif
     --}}