@php
    $requiredNow = isset($required) ? $required : null;
    if(!$requiredNow){
        $requiredNow = ($address->cep || $address->logradouro || $address->numero || $address->bairro || $address->pais) ? true : null;
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
<div>
    <div class="sm:flex">
        <!-- CEP Field -->
        <div class="sm:max-w-[7.5em] w-full" wire:ignore x-init="initZipCodeMask($refs.cep)">
            {!! Form::label('cep', __('ZIP Code'),['class' => "block mx-1 $labelRequired"]) !!}
            <div class="relative">
                {!! Form::text('cep', $address->cep, ['class' => 'input sm:max-w-[7.5em] w-full',
                $requiredAttr => $requiredValue,
                'wire:model.blur' => 'address.cep',
                'x-ref' => 'cep',
                // 'x-on:input' => $required ? '' : 'toggleRequiredAddressFields',
                'id' => 'cep']) !!}
                <x-loader class="absolute top-[15px] left-[70%]" wire:loading wire:target="address.cep" />
            </div>
        </div>
        <!-- Logradouro Field -->
        <div class="sm:flex-1 sm:mx-2">
            {!! Form::label('logradouro',__('Address'),['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('logradouro', $address->logradouro, ['class' => 'input w-full',
            $requiredAttr => $requiredValue,
            'x-on:input' => $requiredNow ? '' : 'toggleRequiredAddressFields',
            'wire:model' => 'address.logradouro',
            'id' => 'logradouro']) !!}
        </div>
        <!-- Numero Field -->
        <div class="sm:max-w-[4.5em] w-full">
            {!! Form::label('numero', __('Number'),['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('numero', $address->numero, ['class' => 'input sm:max-w-[4.5em] w-full',
            $requiredAttr => $requiredValue, 
            'x-on:input' => $requiredNow ? '' : 'toggleRequiredAddressFields',
            'wire:model' => 'address.numero',
            ]) !!}
        </div>
    </div>

    <div class="sm:flex">
        <!-- Pais Fields -->
        <div class="sm:grow">
            {!! Form::label('bairro', __('Neighborhood'),['class' => "block mx-1 $labelRequired"]) !!}
            {!! Form::text('bairro', $address->bairro, ['class' => 'input w-full',
            $requiredAttr => $requiredValue,
            'wire:model' => 'address.bairro',
            'x-on:input' => $requiredNow ? '' : 'toggleRequiredAddressFields',
            'id' => 'bairro']) !!}
        </div>
        <div class="sm:flex-1 sm:ml-2">
            {!! Form::label('complemento', __('Complement'),['class' => "block mx-1"]) !!}
            {!! Form::text('complemento', $address->complemento, ['class' => 'input w-full', 
            'wire:model' =>'address.complemento'
            ]) !!}
        </div>

    </div>

    <livewire:country-state-city-address :required="$required" :address="$address" key={{now()}}/>

</div>

@push('scripts')
    <script>        
        function initZipCodeMask(cep){            
            let lang = navigator.language
            switch(lang){
                case 'pt-BR': {
                    IMask(cep,{
                        mask: '00000-000'
                    })   
                    break
                }
                default: { break; }
            }
        }

        @if(!$requiredNow)

           function toggleRequiredAddressFields(){
                let filledInputs = Array.from(document.querySelectorAll('#cep,#logradouro,#numero,#bairro,#pais')).map(element => element.value ? true : false)                         
                
                if(filledInputs.includes(true)){
                    document.querySelectorAll('#cep,#logradouro,#numero,#bairro,#pais').forEach((el)=>{
                        el.setAttribute('required','true')
                        el.labels[0].classList.add('required')
                    })
                }else{                    
                    document.querySelectorAll('#cep,#logradouro,#numero,#bairro,#pais').forEach((el)=>{
                        el.removeAttribute('required')
                        el.labels[0].classList.remove('required')
                    })
                }
           }

        @endif
        
    </script>
@endpush