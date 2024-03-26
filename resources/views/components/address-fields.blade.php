
@php
    $required = isset($required) ? $required : null;
    $labelRequired = $required ? 'required' : '';
@endphp

<div class="sm:flex">
    <!-- CEP Field -->
    <div class="sm:max-w-[7.5em] w-full">
        {!! Form::label('cep', __('ZIP Code').':',['class' => "block mx-1 $labelRequired"]) !!}
        {!! Form::text('cep', null, ['class' => 'input sm:max-w-[7.5em] w-full', $required ?? '' => $required ? 'required' : '','wire:model.live.debounce.300' => 'cep','id' => 'cep']) !!}
    </div>
    <!-- Logradouro Field -->
    <div class="sm:flex-1 sm:mx-2">
        {!! Form::label('logradouro',__('Address').':',['class' => "block mx-1 $labelRequired"]) !!}
        {!! Form::text('logradouro', null, ['class' => 'input w-full',$required ?? '' => $required ? 'required' : '','wire:model.live.debounce.300' => 'logradouro','id' => 'logradouro']) !!}
    </div>
    <!-- Numero Field -->
    <div class="sm:max-w-[4.5em] w-full">
        {!! Form::label('numero', __('Number').':',['class' => "block mx-1 $labelRequired"]) !!}
        {!! Form::text('numero', null, ['class' => 'input sm:max-w-[4.5em] w-full',$required ?? '' => $required ? 'required' : '', 'wire:model.live.debounce.300' => 'numero',]) !!}
    </div>
</div>

<div class="sm:flex">
    <!-- Pais Fields -->
    <div class="sm:grow">
        {!! Form::label('bairro', __('Neighborhood').':',['class' => "block mx-1 $labelRequired"]) !!}
        {!! Form::text('bairro', null, ['class' => 'input w-full',$required ?? '' => $required ? 'required' : '', 'wire:model.live.debounce.300' => 'bairro','id' => 'bairro']) !!}
    </div>
    <div class="sm:flex-1 sm:ml-2">
        {!! Form::label('complemento', __('Complement').':',['class' => "block mx-1"]) !!}
        {!! Form::text('complemento', null, ['class' => 'input w-full', 'wire:model' => 'complemento']) !!}
    </div>

</div>

<livewire:country-state-city-address :required="$required" key="{{ now() }}" :endereco="$endereco"/>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
            switch(navigator.language){
                case 'pt-BR': {
                    let cep = document.querySelector('#cep') 
                    let cepValue = IMask(cep,{
                        mask: '00000-000'
                    })  

                    let focusout = (e) => {
                        if(e.target.value.length == 9){ //Brazilian ZIP Code completed
                            Swal.showLoading()
                            fetch(`{{route('admin.consultarCEP','')}}/${cepValue.unmaskedValue}`).then((response) => {
                                return response.json()
                            }).then((data) => {
                                if(data.erro) throw new Exception()
                                populateAddress(
                                                cep.value,
                                                data.logradouro,
                                                '',
                                                data.bairro,
                                                '',
                                                data.uf,
                                                data.localidade,
                                                'BR')
                                Swal.close()
                            }).catch((e) => {
                                cep.removeEventListener('focusout',focusout)
                                Swal.fire({
                                    icon: 'error',
                                    title: "{{__('Error While Fetching ZIP Code, insert the data manually')}}",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(()=>{
                                    cep.blur()                    
                                    cep.addEventListener('focusout',focusout)          
                                })
                            })
                        }
                    }

                    cep.addEventListener('focusout',focusout)          
                    break
                }
                default: break
            }

            @if(!$required)             
                let require = false
                cep.addEventListener('input',(e)=>{
                    console.log('digitou');
                    if(!e.target.value || e.target.value == "" && require){
                        document.querySelectorAll('#cep,#logradouro,#numero,#bairro,#pais,#estado,#cidade').forEach((input)=>{
                            input.removeAttribute('required')
                            input.labels[0].classList.remove('required')
                        })
                        require = false
                    }else{
                        if(!require){
                            document.querySelectorAll('#cep,#logradouro,#numero,#bairro,#pais,#estado,#cidade').forEach((input)=>{
                                input.setAttribute('required','true')
                                input.labels[0].classList.add('required')
                            })
                            require = true
                        }
                    }
                })
            @endif

            // document.querySelector('#pais').addEventListener('change',(e)=>{
                
            //     let estado = document.querySelector('#estado').value,
            //         cidade = document.querySelector('#cidade').value

            //     if(!e.target.value || e.target.value == ''){
            //         estado = ''
            //         cidade = ''
            //     }

            //     populateAddress(
            //                     document.querySelector('#cep').value,
            //                     document.querySelector('#logradouro').value,
            //                     document.querySelector('#numero').value,
            //                     document.querySelector('#bairro').value,
            //                     document.querySelector('#complemento').value,
            //                     estado,
            //                     cidade,
            //                     e.target.value
            //                     )
            // })

            // document.querySelector('#estado').addEventListener('change',(e)=>{
                
            //     let cidade = document.querySelector('#cidade').value

            //     if(!e.target.value || e.target.value == ''){
            //         cidade = ''
            //     }

            //     populateAddress(
            //                     document.querySelector('#cep').value,
            //                     document.querySelector('#logradouro').value,
            //                     document.querySelector('#numero').value,
            //                     document.querySelector('#bairro').value,
            //                     document.querySelector('#complemento').value,
            //                     e.target.value,
            //                     cidade,
            //                     document.querySelector('#pais').value,
            //                     )
            // })

            // document.querySelector('#cidade').addEventListener('change',(e)=>{
            //     populateAddress(
            //             document.querySelector('#cep').value,
            //             document.querySelector('#logradouro').value,
            //             document.querySelector('#numero').value,
            //             document.querySelector('#bairro').value,
            //             document.querySelector('#complemento').value,
            //             document.querySelector('#estado').value,
            //             e.target.value,
            //             document.querySelector('#pais').value,
            //             )
            // })


        })

        function populateAddress(cep,logradouro,numero,bairro,complemento,estado,cidade,pais){
            Livewire.dispatch('populateAddress', {
                address: {
                    cep: cep,
                    logradouro: logradouro,
                    numero: numero,
                    bairro: bairro,
                    complemento: complemento,
                    estado: estado,
                    cidade: cidade,
                    pais: pais
                }
            });
        }


</script>
@endpush