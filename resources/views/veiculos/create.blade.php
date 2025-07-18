<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">
        @if($Veiculo)
            {{__('Update register')}}
        @else
            {{__('Create new register')}}
        @endif 
    </x-slot>

    <x-slot name="content"> 
        @include('adminlte-templates::common.errors')
        {!! Form::model($Veiculo,['route' => $Veiculo ? ['admin.veiculos.update',$Veiculo->id] : 'admin.veiculos.store', 'method' => $Veiculo ? 'PATCH' : 'post','id' => 'formVeiculos']) !!}
        
            <div wire:key='veiculos' id="veiculosFields"> 
               <x-stepper>
                    <x-stepper-item icon="fa-solid fa-info" active-stepper/>
                    <x-stepper-item icon="fa-solid fa-folder-open" />
                </x-stepper> 
                <div class="my-2" stepper-fields >
                    <div>
                        <h1 class="m-auto text-2xl">{{__('Vehicle Info')}}</h1>
                        @include('veiculos.fields')
                    </div>
                    <div class="hidden">
                        <h1 class="m-auto text-2xl">{{__('Vehicle Papers')}}  @if($Veiculo && $Veiculo->documento) - <a href="{{ route('admin.veiculos.getDocument', $Veiculo->id) }}" class="text-blue-400" target="_blank">{{ __('Check Document') }}</a>@endif</h1>
                        @include('veiculos.docs-fields')
                    </div>
                </div>
            </div>

     </x-slot> 
        
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> 
            @if($Veiculo) {{__('Update') }} @else {{__('Add')}} @endif 
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> 