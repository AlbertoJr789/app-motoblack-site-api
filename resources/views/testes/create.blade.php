<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">
        @if($Teste)
            {{__('Update register')}}
        @else
            {{__('Create new register')}}
        @endif
    </x-slot>

    <x-slot name="content">
        @include('adminlte-templates::common.errors')
        {!! Form::model($Teste,['wire:submit.prevent' => 'submit', 'id' => 'formTestes']) !!}
            @include('testes.fields')
    </x-slot>

    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit">
            @if($Teste) {{__('Update') }} @else {{__('Add')}}   @endif
            <x-loader wire:loading wire:target="submit"/>
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal>
