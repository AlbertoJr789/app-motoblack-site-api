<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
@else
    @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:') !!}
@endif
    @{!! Form::select('{{ $fieldName }}', @php echo htmlspecialchars_decode($selectValues) @endphp, null, ['class' => 'form-control custom-select']) !!}
</div>