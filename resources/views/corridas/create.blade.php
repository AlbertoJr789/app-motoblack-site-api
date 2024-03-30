<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">
        @if($Corrida)
            {{__('Update register')}}
        @else
            {{__('Create new register')}}
        @endif 
    </x-slot>

    <x-slot name="content"> 
        @include('adminlte-templates::common.errors')
        {!! Form::model($Corrida,['route' => $Corrida ? ['admin.corridas.update',$Corrida->id] : 'admin.corridas.store', 'method' => $Corrida ? 'PATCH' : 'post','id' => 'formCorridas']) !!}

            <div wire:key='corridas'> 
               <x-stepper>
                    <x-stepper-item icon="fa-solid fa-info" active-stepper="0"/>
                </x-stepper> 
                <div class="my-2" stepper-fields >
                    <div>
                        <h1 class="m-auto text-2xl">{{__('Info')}}</h1>
                        @include('corridas.fields')
                    </div>
                </div>
            </div>


     </x-slot> 
        
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> 
            @if($Corrida) {{__('Update') }} @else {{__('Add')}} @endif 
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> 