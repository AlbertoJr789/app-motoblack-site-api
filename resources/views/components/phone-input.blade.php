@props([
    'name' => 'phone',
    'value' => null,
    'required' => false
])


@php
    $flags = [
        '' => '...',
        '+55' => '🇧🇷',
    ];
    $currentFlag = explode(' ', $value)[0];
@endphp

<div class="relative mb-4 flex flex-wrap items-stretch">
    <input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" hidden>
    {!! Form::select('', $flags, $currentFlag, [
        'class' => 'input rounded-tr-none rounded-br-none border-r-0',
        'id' => $name . 'Select',
    ]) !!}
    <x-input type="text" id="{{ $name }}Input" class="flex-auto rounded-tl-none rounded-bl-none"
        placeholder="{{ __('Type your phone number').'...' }}" />
</div>

@push('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            let phoneFinalValue = document.querySelector("#{{ $name }}")
            let input = document.querySelector("#{{ $name }}Input")
            let phoneMask = IMask(input, { mask: '' })
            let select = document.querySelector("#{{ $name }}Select")
            select.addEventListener('change', (e) => {
                console.log('change');
                switch (e.target.value) {
                    case '+55': {
                        console.log('mask br');
                        phoneMask.updateOptions({
                            mask: [{
                                mask: '(00) 00000-0000'
                            },{
                                mask: '(00) 0000-0000'
                            }],
                            dispatch: (appended, dynamicMasked) => {
                                let val = dynamicMasked.value + appended
                                return val.length <= 14 ? dynamicMasked.compiledMasks[1] : dynamicMasked.compiledMasks[0];
                            }
                        })
                        break
                    }
                    default: {
                        phoneMask.updateOptions({ mask: '' })
                    }
                }
            })

            input.addEventListener('input',(e)=>{
                phoneFinalValue.value = `${select.value} ${e.target.value}`
            })

            select.dispatchEvent(new Event('change'))

           
        })

        function validate{{ucfirst($name)}}(){
            let input = document.querySelector("#{{ $name }}Input")
            let select = document.querySelector("#{{ $name }}Select")
            switch(select.value){
                case '+55':{
                    return /\([0-9][0-9]\) [0-9]{4,5}-[0-9]{4}/.test(input.value)
                }
                default: return {{ !$required ? 'true': 'false' }}
            }
        }
    </script>
@endpush
