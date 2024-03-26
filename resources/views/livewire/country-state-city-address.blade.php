@php
    $required = isset($required) ? $required : null;
    $labelRequired = $required ? 'required' : '';
@endphp

<div class="sm:flex">
    <div class="grow">
        {!! Form::label('pais', __('Country').':',['class' => "block mx-1 $labelRequired"]) !!}
        <div class="relative">
            {!! Form::select('pais', $paises, $pais, ['class' => 'input w-full',
            $required ?? '' => $required ? 'required' : '', 'wire:model.live.debounce.500' => 'pais','id' => 'pais']) !!}
            <x-loader class="absolute top-[35%] left-[80%]"  wire:loading wire:target="pais"/>
        </div>
    </div>
    <!-- Bairro Field -->
    <div class="grow sm:mx-2">
        {!! Form::label('estado', __('State').':',['class' => "block mx-1 $labelRequired"]) !!}
        <div class="relative">
            {!! Form::select('estado', $estados, $estado,['class' => 'input w-full',
            $required ?? '' => $required ? 'required' : '', 'wire:model.live.debounce.500' => 'estado', 'id' => 'estado']) !!}
            <x-loader class="absolute top-[35%] left-[80%]"  wire:loading wire:target="estado"/>
        </div>
    </div>
    <!-- Cidade Field -->
    <div class="grow">
        {!! Form::label('cidade', __('City').':',['class' => "block mx-1 $labelRequired"]) !!}
        {!! Form::select('cidade', $cidades, $cidade, ['class' => 'input w-full',$required ?? '' => $required ? 'required' : '', 'wire:model.live.debounce.500' => 'cidade']) !!}
    </div>
</div>
