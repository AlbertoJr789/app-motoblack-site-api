<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('img/moto_black_logo.png')}}" alt="Logo Moto Black" class="h-60 w-60">
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('createAgent')}}" enctype="multipart/form-data">
            @csrf
           
            <x-stepper>
                <x-stepper-item icon="fa-solid fa-info" active-stepper/>
                <x-stepper-item icon="fa-solid fa-location-dot"/>
                <x-stepper-item icon="fa-solid fa-car"/>
                <x-stepper-item icon="fa-solid fa-folder-open"/>
            </x-stepper>
            <div  stepper-fields >
                <div>

                    <h1 class="m-auto text-2xl">{{__('Personal Info')}}</h1>
                    <div>
                        <x-label for="name" value="{{ __('User Name') }}" class="required"/>
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required="true" autofocus autocomplete="name" />
                    </div>
        
                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                    </div>
        
                    <div class="mt-4">
                        <x-label for="telefone" value="{{ __('Phone Number') }}" />
                        <x-phone-input id="telefone" class="block mt-1" name="telefone" />     
                    </div>
        
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" class="required" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>
                    
                </div>

                <div class="hidden">
                    <h1 class="text-2xl">{{__('Address')}}</h1>
                    <livewire:address-fields :required="true" />
                </div>

                <div class="hidden">
                    <h1 class="text-2xl">{{__('Vehicle Info')}}</h1>
                    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4 my-2">
                        
                        <!-- Tipo Field -->
                        <div>
                            {!! Form::label('tipo', __('Type'),['class' => "block mx-1 required"]) !!}
                            {!! Form::select('tipo', ['1' => __('Motorcycle'),'2' => __('Car')],null, ['class' => 'input w-full','required'=>'true',]) !!}
                        </div>

                        <div>
                            {!! Form::label('marca', __('Brand'),['class' => "block mx-1 required"]) !!}
                            {!! Form::text('marca', null, ['class' => 'input w-full','required'=>'true',]) !!}
                        </div>
                        <!-- Modelo Field -->
                        <div>
                            {!! Form::label('modelo', __('Model'),['class' => "block mx-1 required"]) !!}
                            {!! Form::text('modelo', null, ['class' => 'input w-full','required'=>'true' ]) !!}
                        </div>
                        <!-- Placa Field -->
                        <div>
                            {!! Form::label('placa', __('License Plate'),['class' => "block mx-1 required"]) !!}
                            {!! Form::text('placa', null, ['class' => 'input w-full','required'=>'true']) !!}
                        </div>

                    </div>
                    <!-- Cor Field -->
                    <div class="grid sm:grid-cols-2 grid-cols-1">
                        <div>
                            {!! Form::label('cor', __('Color'),['class' => "block mx-1 required"]) !!}
                            {!! Form::color('cor', null, ['class' => 'input','required'=>'true']) !!}
                        </div>
                    </div>
                </div>

                <div class="hidden">
                    <h1 class="text-2xl">{{__('Documents')}}</h1>
                    <span>{{__('We\'re gonna need some documents to analyze your appliance')}}.</span>
                    
                    <Filepicker accept="image/*,application/pdf" name="driver_license" class="mt-4 mb-4" required>
                        {{ __('Driver\'s License') }}
                    </Filepicker>

                    <Filepicker accept="image/*,application/pdf" name="vehicle_doc" class="mb-4" required>
                        {{ __('Vehicle document') }}
                    </Filepicker>
                    
                    <Filepicker accept="image/*,application/pdf" name="address_proof" required >
                        {{ __('Billing Address') }}
                    </Filepicker>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </div>

            </div>
        </form>
    </x-authentication-card>
    @push('scripts')
        <script>
            function submitRegister(){
                if(!validateTelefone()){
                    Swal.fire({
                        icon: 'warning',
                        title: `{{__('Invalid Fields')}}`,
                        text: `{{__('The given phone number is invalid!')}}`,
                    })
                    return
                }
                document.querySelector('#submit').click()
            }

            window.addEventListener('stepperChanged', function(a) {
                if(a.detail.activeStepper == 1){
                    document.querySelector('#authCard').classList.remove('sm:max-w-md')
                    document.querySelector('#authCard').classList.add('sm:w-1/2')
                }else{
                    document.querySelector('#authCard').classList.remove('sm:w-1/2')
                    document.querySelector('#authCard').classList.add('sm:max-w-md')
                }
            })

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('alert',(e)=>{
                    Swal.fire({
                        icon: e[0].icon,
                        title: e[0].title,
                        text: e[0].text
                    })
                })
            })

        </script>
    @endpush
</x-guest-layout>
