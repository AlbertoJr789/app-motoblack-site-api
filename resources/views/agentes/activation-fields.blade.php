

<x-accordion class="mt-4">
    
    <x-accordion-item title="{{__('Documents')}}" :opened="true">
        <span>{{__('Check if the agent\'s documents are valid')}}.</span>

        <div class="grid sm:grid-cols-3 grid-cols-1 gap-6 my-2">
            @if($Agente && !$Agente->veiculo_ativo_id)
            <div class="text-center">
                {!! Form::label('', __('Billing Address'),['class' => "block mx-1"]) !!}
                <a href="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=address_proof" target="_blank"><img src="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=address_proof" alt="{{__('Billing Address')}}" class="w-full h-auto"></a>
            </div>
            
            <div class="text-center">
                {!! Form::label('', __('Driver\'s License'),['class' => "block mx-1"]) !!}
                <a href="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=driver_license" target="_blank"><img src="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=driver_license" alt="{{__('Driver\'s License')}}" class="w-full h-auto"></a>
            </div>

            <div class="text-center">
                {!! Form::label('', __('Vehicle document'),['class' => "block mx-1"]) !!}
                <a href="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=vehicle_doc" target="_blank"><img src="{{route('admin.agentes.getDocument',$Agente->id)}}?doc=vehicle_doc" alt="{{__('Vehicle document')}}" class="w-full h-auto"></a>
            </div>
            @endif
        </div>
    </x-accordion-item>

    <x-accordion-item title="{{__('Address')}}">
        <span>{{__('Check if the address data is just the way it is presented in the document')}}. {{__('Make the necessary changes or deactivate the agent if the fields don\'t match to the document that was sent')}}.</span>
        <livewire:address-fields :required="true" key={{now()}} :addr="$Agente?->pessoa?->endereco" class="my-2"/>
    </x-accordion-item>

    <x-accordion-item title="{{__('Vehicle Info')}}">
        <span>{{__('Check if the vehicle data is just the way it is presented in the document')}}. {{__('Make the necessary changes or deactivate the agent if the fields don\'t match to the document that was sent')}}.</span>

        <div class="grid sm:grid-cols-3 grid-cols-1 gap-4 my-2">
            <!-- Tipo Field -->
            <div>
                {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1 required"]) !!}
                {!! Form::select('tipo', ['1' => __('Motorcycle'),'2' => __('Car')],null, ['class' => 'input w-full','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id',]) !!}
            </div>

            <div>
                {!! Form::label('marca', 'Marca:',['class' => "block mx-1 required"]) !!}
                {!! Form::text('marca', null, ['class' => 'input w-full','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id',]) !!}
            </div>
            <!-- Modelo Field -->
            <div>
                {!! Form::label('modelo', 'Modelo:',['class' => "block mx-1 required"]) !!}
                {!! Form::text('modelo', null, ['class' => 'input w-full','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id' ]) !!}
            </div>
            <!-- Placa Field -->
            <div>
                {!! Form::label('placa', 'Placa:',['class' => "block mx-1 required"]) !!}
                {!! Form::text('placa', null, ['class' => 'input w-full','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id']) !!}
            </div>
            <!-- Renavam Field -->
            <div>
                {!! Form::label('renavam', 'Renavam:',['class' => "block mx-1 required"]) !!}
                {!! Form::text('renavam', null, ['class' => 'input w-full','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id']) !!}
            </div>
            <!-- Chassi Field -->
            <div>
                {!! Form::label('chassi', 'Chassi:',['class' => "block mx-1 required"]) !!}
                {!! Form::text('chassi', null, ['class' => 'input w-full','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id']) !!}
            </div>
        </div>

        <!-- Cor Field -->
        <div class="grid sm:grid-cols-2 grid-cols-1">
            <div>
                {!! Form::label('cor', 'Cor:',['class' => "block mx-1"]) !!}
                {!! Form::color('cor', null, ['class' => 'input','x-bind:required'=>'$wire.active && !$wire.veiculo_ativo_id']) !!}
            </div>
        </div>
    </x-accordion-item>

</x-accordion>


