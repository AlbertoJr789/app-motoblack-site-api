<x-dialog-modal wire:model.live="open" id="modalCreate" maxWidth="3xl">
    <x-slot name="title">
        @if($Pessoa)
            {{__('Update register')}}
        @else
            {{__('Create new register')}}
        @endif 
    </x-slot>

    <x-slot name="content"> 
        @include('adminlte-templates::common.errors')
        {!! Form::model($Pessoa,['wire:submit.prevent' => 'submit', 'id' => 'formPessoas']) !!}
            
            <x-stepper>
                <x-stepper-item icon="fa-solid fa-info" active-stepper="0"/>
                <x-stepper-item icon="fa-solid fa-location-dot"/>
            </x-stepper>

            <div class="my-2" stepper-fields>
                <div>
                    <h1 class="m-auto text-2xl">{{__('Personal Info')}}</h1>
                    @include('pessoas.fields')
                </div>
                <div class="hidden">
                    <h1 class="text-2xl">{{__('Address')}}</h1>
                    <x-address-fields/>
                </div>
            </div>

     </x-slot> 
        
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> 
            @if($Pessoa) {{__('Update') }} @else {{__('Add')}}   @endif 
            <x-loader wire:loading wire:target="submit"/>
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> 