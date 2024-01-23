
<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">
        {{__('Create new register')}}
    </x-slot>

    <x-slot name="content">
        @include('adminlte-templates::common.errors')
        {!! Form::model($teste,['wire:submit.prevent' => 'submit']) !!}
                @include('testes.fields')
    </x-slot>

    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit" wire:loading>
            <div></div>
            {{__('Add')}}
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal>