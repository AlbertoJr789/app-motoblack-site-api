@php
    $requiredNow = isset($required) ? $required : null;
    if(!$requiredNow){
        $requiredNow = $address->pais ? true : null;
        if(!$requiredNow){
            $requiredAttr = "requiredFalse";
            $requiredValue = "false";
        }else{
            $requiredAttr = "required";
            $requiredValue = "true";
        }
    }else{
        $requiredAttr = "required";
        $requiredValue = "true";
    }
    $labelRequired = $requiredNow ? 'required' : '';
@endphp

<div class="sm:flex">
    <div class="grow">
        {!! Form::label('pais', __('Country'),['class' => "block mx-1 $labelRequired"]) !!}
        <div class="relative">
            {!! Form::select('pais', $paises, $address->pais, ['class' => 'input w-full',
            $requiredAttr => $requiredValue,
            'wire:model.live.debounce.500' => 'address.pais',
            'data-placeholder' => 'Selecione...',
            'id' => 'pais']) !!}
            <x-loader class="absolute top-[35%] left-[80%]"  wire:loading wire:target="address.pais"/>
        </div>
    </div>
    <!-- Bairro Field -->
    <div class="grow sm:mx-2">
        {!! Form::label('estado', __('State'),['class' => "block mx-1 $labelRequired"]) !!}
        <div class="relative">
            {!! Form::select('estado', $estados, $address->estado,['class' => 'input w-full',
            $requiredAttr => $requiredValue, 'wire:model.live.debounce.500' => 'address.estado', 'id' => 'estado']) !!}
            <x-loader class="absolute top-[35%] left-[80%]"  wire:loading wire:target="address.estado"/>
        </div>
    </div>
    <!-- Cidade Field -->
    <div class="grow">
        {!! Form::label('cidade', __('City'),['class' => "block mx-1 $labelRequired"]) !!}
        {!! Form::select('cidade', $cidades, $address->cidade, ['class' => 'input w-full',$requiredAttr => $requiredValue, 'wire:model.live.debounce.500' => 'address.cidade']) !!}
    </div>
</div>
