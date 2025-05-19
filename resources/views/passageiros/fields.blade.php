
@if($Passageiro)
    <div class="flex sm:justify-start justify-center sm:my-auto my-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>

    <div class="grid sm:grid-cols-2 sm:gap-6 grid-cols-1" x-show="!$wire.active">
        <div>
            {!! Form::label('motivo_inativo', 'Motivo Inativo:',['class' => "block mx-1 required"]) !!}
            {!! Form::text('motivo_inativo', null, ['class' => 'input w-full','wire:model' => 'motivo_inativo','x-bind:required'=>'!$wire.active']) !!}
        </div>
    </div>

@endif
    