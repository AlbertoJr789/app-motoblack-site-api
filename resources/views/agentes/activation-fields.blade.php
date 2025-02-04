

<x-accordion class="mt-4">
    
    <x-accordion-item title="{{__('Documents')}}" :opened="true">
        <span class="text-sm">{{__('Check if the agent\'s documents are valid')}}.</span>

        <div class="grid sm:grid-cols-3 grid-cols-1 gap-6 my-4">
            @if($Agente && $Agente->em_analise)
            <div class="text-center">
                {!! Form::label('', __('Billing Address'),['class' => "block mx-1 text-sm"]) !!}
                <a href="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=address_proof" target="_blank"><img src="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=address_proof" alt="{{__('Billing Address')}}" class="w-full h-auto"></a>
            </div>
            
            <div class="text-center">
                {!! Form::label('', __('Driver\'s License'),['class' => "block mx-1 text-sm"]) !!}
                <a href="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=driver_license" target="_blank"><img src="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=driver_license" alt="{{__('Driver\'s License')}}" class="w-full h-auto"></a>
            </div>

            <div class="text-center">
                {!! Form::label('', __('Vehicle document'),['class' => "block mx-1 text-sm"]) !!}
                <a href="{{route('admin.veiculos.getDocument',$Agente->veiculo_ativo_id)}}" target="_blank"><img src="{{route('admin.veiculos.getDocument',$Agente->veiculo_ativo_id)}}" alt="{{__('Vehicle document')}}" class="w-full h-auto"></a>
            </div>
            @endif
        </div>
    </x-accordion-item>

    <x-accordion-item title="{{__('Address')}}">
        <span class="text-sm text-pretty">{{__('Check if the address data is just the way it is presented in the document')}}. {{__('Make the necessary changes or deactivate the agent if the fields don\'t match to the document that was sent')}}.</span>
        <div class="my-4">
            <livewire:address-fields :required="true" key={{now()}} :addr="$Agente?->pessoa?->endereco" />
        </div>
    </x-accordion-item>

    <x-accordion-item title="{{__('Vehicle Info')}}">
        <span class="text-sm text-pretty">{{__('Check if the vehicle data is just the way it is presented in the document')}}. {{__('Make the necessary changes or deactivate the agent if the fields don\'t match to the document that was sent')}}.</span>

        <div class="grid sm:grid-cols-3 grid-cols-1 gap-4 my-4 ">
            <!-- Tipo Field -->
            <div>
                {!! Form::label('tipo', __('Type'),['class' => "block mx-1 required"]) !!}
                {!! Form::select('tipo', ['1' => __('Motorcycle'),'2' => __('Car')],$Agente?->activeVehicle?->tipo->value, ['class' => 'input w-full','x-bind:required'=>'$wire.active && $wire.em_analise',]) !!}
            </div>

            <div>
                {!! Form::label('marca', __('Brand'),['class' => "block mx-1 required"]) !!}
                {!! Form::text('marca', $Agente?->activeVehicle?->marca, ['class' => 'input w-full','x-bind:required'=>'$wire.active && $wire.em_analise',]) !!}
            </div>
            <!-- Modelo Field -->
            <div>
                {!! Form::label('modelo', __('Model'),['class' => "block mx-1 required"]) !!}
                {!! Form::text('modelo', $Agente?->activeVehicle?->modelo, ['class' => 'input w-full','x-bind:required'=>'$wire.active && $wire.em_analise' ]) !!}
            </div>
            <!-- Placa Field -->
            <div>
                {!! Form::label('placa', __('License Plate'),['class' => "block mx-1 required"]) !!}
                {!! Form::text('placa', $Agente?->activeVehicle?->placa, ['class' => 'input w-full','x-bind:required'=>'$wire.active && $wire.em_analise']) !!}
            </div>
            <!-- Renavam Field -->
            <div>
                {!! Form::label('renavam', 'Renavam',['class' => "block mx-1 required"]) !!}
                {!! Form::text('renavam', $Agente?->activeVehicle?->renavam, ['class' => 'input w-full','x-bind:required'=>'$wire.active && $wire.em_analise']) !!}
            </div>
            <!-- Chassi Field -->
            <div>
                {!! Form::label('chassi', 'Chassi',['class' => "block mx-1 required"]) !!}
                {!! Form::text('chassi', $Agente?->activeVehicle?->chassi, ['class' => 'input w-full','x-bind:required'=>'$wire.active && $wire.em_analise']) !!}
            </div>
        </div>

        <!-- Cor Field -->
        <div class="grid sm:grid-cols-2 grid-cols-1">
            <div>
                {!! Form::label('cor', __('Color'),['class' => "block mx-1"]) !!}
                {!! Form::color('cor', $Agente?->activeVehicle?->cor, ['class' => 'input','x-bind:required'=>'$wire.active && $wire.em_analise']) !!}
            </div>
        </div>
    </x-accordion-item>

</x-accordion>


