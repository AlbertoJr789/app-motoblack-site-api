@php
    $required = isset($required) ? $required : null;
    $labelRequired = $required ? 'required' : '';
@endphp
<div>
    <div class="sm:flex">
        <!-- CEP Field -->
        <div class="sm:max-w-[7.5em] w-full">
            {!! Form::label('cep', __('ZIP Code').':',['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('cep', null, ['class' => 'input sm:max-w-[7.5em] w-full', $required ?? '' => $required ?
            'required' : '','wire:model.blur' => 'cep','id' => 'cep']) !!}
            <x-loader class="absolute top-[42%] left-[12%]" wire:loading wire:target="cep" />
        </div>
        <!-- Logradouro Field -->
        <div class="sm:flex-1 sm:mx-2">
            {!! Form::label('logradouro',__('Address').':',['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('logradouro', null, ['class' => 'input w-full',$required ?? '' => $required ? 'required' :
            '','wire:model.live.debounce.500' => 'logradouro','id' => 'logradouro']) !!}
        </div>
        <!-- Numero Field -->
        <div class="sm:max-w-[4.5em] w-full">
            {!! Form::label('numero', __('Number').':',['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('numero', null, ['class' => 'input sm:max-w-[4.5em] w-full',$required ?? '' => $required ?
            'required' : '', 'wire:model.live.debounce.500' => 'numero',]) !!}
        </div>
    </div>

    <div class="sm:flex">
        <!-- Pais Fields -->
        <div class="sm:grow">
            {!! Form::label('bairro', __('Neighborhood').':',['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('bairro', null, ['class' => 'input w-full',$required ?? '' => $required ? 'required' : '',
            'wire:model.live.debounce.500' => 'bairro','id' => 'bairro']) !!}
        </div>
        <div class="sm:flex-1 sm:ml-2">
            {!! Form::label('complemento', __('Complement').':',['class' => "block mx-1"]) !!}
            {!! Form::text('complemento', null, ['class' => 'input w-full', 'wire:model.live.debounce.500' =>
            'complemento']) !!}
        </div>

    </div>

    <livewire:country-state-city-address :required="$required" key="{{now()}}" :endereco="$endereco" />

</div>

@script
<script>
   let lang = navigator.language
   switch(lang){
        case 'pt-BR': {
            let cep = document.querySelector('#cep') 
            console.log('mask');
            let cepValue = IMask(cep,{
                mask: '00000-000'
            })   
            break
        }
        default: break
    }
</script>
@endscript