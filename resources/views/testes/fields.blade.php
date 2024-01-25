
<!-- Teste Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        {!! Form::label('teste', 'Teste:',['class' => "block mx-1"]) !!}
        {!! Form::text('teste', null, ['class' => 'input','required' => 'true','wire:model.live' => 'teste','id' => 'teste']) !!}
    </div>
</div>
