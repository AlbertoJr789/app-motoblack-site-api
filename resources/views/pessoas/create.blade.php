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
        {!! Form::model($Pessoa,['route' => $Pessoa ? ['admin.pessoas.update',$Pessoa->id] : 'admin.pessoas.store', 'method' => $Pessoa ? 'PATCH' : 'post', 'id' => 'formPessoas']) !!}
            
            <div wire:key='pessoa'>
                <x-stepper>
                    <x-stepper-item icon="fa-solid fa-info" active-stepper="0"/>
                    <x-stepper-item icon="fa-solid fa-location-dot"/>
                </x-stepper>
                <div class="my-2" stepper-fields >
                    <div wire:ignore>
                        <h1 class="m-auto text-2xl">{{__('Personal Info')}}</h1>
                        @include('pessoas.fields')
                        
                        <div class="grid sm:grid-cols-2 grid-cols-1" x-show="$wire.showActive">
                            <div class="flex sm:justify-start justify-center sm:my-auto my-4">
                                {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
                                {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active']) !!}
                            </div>
                        </div>
                    
                    </div>
                    <div class="hidden">
                        <h1 class="text-2xl">{{__('Address')}}</h1>
                        <livewire:address-fields key={{now()}} :addr="$endereco"/>
                    </div>
                </div>
            </div>

     </x-slot> 
        
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> 
            @if($Pessoa) {{__('Update') }} @else {{__('Add')}}   @endif 
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> 