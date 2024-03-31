
@if($Passageiro)
    <div class="flex sm:justify-start justify-center sm:my-auto my-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>
@endif
    