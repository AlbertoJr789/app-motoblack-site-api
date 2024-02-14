<!-- {{ $fieldName }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:') !!}
@endif
    @{!! Form::password('{{ $fieldName }}', ['class' => 'form-control'@php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp]) !!}
</div>