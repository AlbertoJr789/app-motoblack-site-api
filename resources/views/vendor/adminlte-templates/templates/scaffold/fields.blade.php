<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    @if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
    @else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:') !!}
    @endif
        <p>@{{ ${!! $config->modelNames->camel !!}->{!! $fieldName !!} }}</p>
</div>

@if($Teste)
<div class="flex sm:justify-start justify-center sm:my-auto my-4">
    {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
    {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
</div>
@endif