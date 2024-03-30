<!-- Pessoa Id Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('pessoa_id', 'Pessoa Id:',['class' => "block mx-1"]) !!}
            {!! Form::text('pessoa_id', null, ['class' => 'input','required' => 'true','wire:model' => 'pessoa_id' ]) !!}
</div>
</div>

<!-- User Id Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
            {!! Form::label('user_id', 'User Id:',['class' => "block mx-1"]) !!}
            {!! Form::text('user_id', null, ['class' => 'input','required' => 'true','wire:model' => 'user_id' ]) !!}
</div>
</div>

@if($Passageiro)
        <div class="flex sm:justify-start justify-center sm:my-auto my-4">
            {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
            {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
        </div>
        @endif
    