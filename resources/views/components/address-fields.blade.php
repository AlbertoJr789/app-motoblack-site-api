
<div class="sm:flex">
    <!-- CEP Field -->
    <div class="sm:max-w-[7.5em] w-full">
        {!! Form::label('cep', __('ZIP Code').':',['class' => "block mx-1"]) !!}
        {!! Form::text('cep', null, ['class' => 'input sm:max-w-[7.5em] w-full','required' => isset($required) && $required ? 'true' : 'false','wire:model' => 'cep' ]) !!}
    </div>
    <!-- Logradouro Field -->
    <div class="sm:flex-1 sm:mx-2">
        {!! Form::label('logradouro',__('Address').':',['class' => "block mx-1"]) !!}
        {!! Form::text('logradouro', null, ['class' => 'input w-full','required' => isset($required) && $required ? 'true' : 'false','wire:model' => 'logradouro' ]) !!}
    </div>
    <!-- Numero Field -->
    <div class="sm:max-w-[4.5em] w-full">
        {!! Form::label('numero', __('Number').':',['class' => "block mx-1"]) !!}
        {!! Form::text('numero', null, ['class' => 'input sm:max-w-[4.5em] w-full','required' => isset($required) && $required ? 'true' : 'false', 'wire:model' => 'numero']) !!}
    </div>
</div>

<div class="sm:flex">
    <!-- Pais Fields -->
    <div class="sm:grow">
        {!! Form::label('bairro', __('Neighborhood').':',['class' => "block mx-1"]) !!}
        {!! Form::text('bairro', null, ['class' => 'input w-full','required' => isset($required) && $required ? 'true' : 'false', 'wire:model' => 'estado']) !!}
    </div>
    <div class="sm:flex-1 sm:ml-2">
        {!! Form::label('complemento', __('Complement').':',['class' => "block mx-1"]) !!}
        {!! Form::text('complemento', null, ['class' => 'input w-full','required' => isset($required) && $required ? 'true' : 'false', 'wire:model' => 'complemento']) !!}
    </div>

</div>

<div class="sm:flex">
    <div class="grow">
        {!! Form::label('pais', __('Country').':',['class' => "block mx-1"]) !!}
        {!! Form::select('pais', ['Brasil' => '🇧🇷 Brasil'], null, ['class' => 'input w-full','required' => isset($required) && $required ? 'true' : 'false', 'wire:model' => 'pais']) !!}
    </div>
     <!-- Bairro Field -->
    <div class="grow sm:mx-2">
        {!! Form::label('estado', __('State').':',['class' => "block mx-1"]) !!}
        {!! Form::select('estado', ['Minas Gerais' => 'Minas Gerais'], null,['class' => 'input w-full','required' => isset($required) && $required ? 'true' : 'false', 'wire:model' => 'bairro']) !!}
    </div>
     <!-- Cidade Field -->
     <div class="grow">
        {!! Form::label('cidade', __('City').':',['class' => "block mx-1"]) !!}
        {!! Form::select('cidade', ['Formiga' => 'Formiga'], null, ['class' => 'input w-full','required' => isset($required) && $required ? 'true' : 'false', 'wire:model' => 'cidade']) !!}
    </div>
</div>


@push('scripts')
    <script>


        document.addEventListener('DOMContentLoaded', function() {
          
        })

    </script>
@endpush
