<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $teste->id }}</p>
</div>

<!-- Teste Field -->
<div class="col-sm-12">
    {!! Form::label('teste', 'Teste:') !!}
    <p>{{ $teste->teste }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $teste->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $teste->updated_at }}</p>
</div>

