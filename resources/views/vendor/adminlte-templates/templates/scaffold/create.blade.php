@verbatim
<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">
        @@if(${{Teste}})
            {{__('Update register')}}
        @@else
            {{__('Create new register')}}
        @@endif
    </x-slot>

    <x-slot name="content"> @endverbatim
        @@include('adminlte-templates::common.errors')
        @{!! Form::model(${{$config->modelNames->name}},['wire:submit.prevent' => 'submit', 'id' => 'form{{$config->modelNames->humanPlural}}}']) !!}
            @@include('{{$config->modelNames->camelPlural}}.fields')
    @verbatim </x-slot> @endverbatim
        @verbatim
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> @endverbatim
            @@if(${{$config->modelNames->name}}) {{__('Update') }} @@else {{__('Add')}}   @@endif @verbatim
            <x-loader wire:loading wire:target="submit"/>
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> @endverbatim