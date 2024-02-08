
<!-- Teste Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        {!! Form::label('teste', 'Teste:',['class' => "block mx-1"]) !!}
        {!! Form::text('teste', $teste, ['class' => 'input','required' => 'true','wire:model' => 'teste','id' => 'teste']) !!}
    </div>
    @if($Teste)
    <div class="flex sm:justify-start justify-center sm:my-auto my-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>
    @endif
</div>
