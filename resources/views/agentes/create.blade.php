<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">
        @if($Agente)
            {{__('Update register')}}
        @else
            {{__('Create new register')}}
        @endif 
    </x-slot>

    <x-slot name="content"> 
        @include('adminlte-templates::common.errors')
        {!! Form::model($Agente,['route' => $Agente ? ['admin.agentes.update',$Agente->id] : 'admin.agentes.store', 'method' => $Agente ? 'PATCH' : 'post','id' => 'formAgentes']) !!}

            <div wire:key='agentes'> 
               <x-stepper>
                    <x-stepper-item icon="fa-solid fa-info" active-stepper="0"/>
                    <x-stepper-item icon="fa-solid fa-address-card" x-show="$wire.active && !$wire.veiculo_ativo_id"/>
                </x-stepper> 
                <div class="my-2" stepper-fields >
                    <div>
                        <h1 class="m-auto text-2xl">{{__('Agent Info')}}</h1>
                        @include('agentes.fields')
                    </div>
                    <div class="hidden">
                        <h1 class="m-auto text-2xl">{{__('Agent Activation')}}</h1>     
                        @include('agentes.activation-fields')                   
                    </div>
                </div>
            </div>


     </x-slot> 
        
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> 
            @if($Agente) {{__('Update') }} @else {{__('Add')}} @endif 
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> 