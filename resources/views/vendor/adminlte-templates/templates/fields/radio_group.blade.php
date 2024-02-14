<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'), ['class' => 'form-check-label']) !!}
@else
    @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}', ['class' => 'form-check-label']) !!}
@endif
    {!! $radioButtons !!}
</div>