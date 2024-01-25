@extends('layouts.app')

@section('content')

    <div class="p-3 w-full h-full">
        @include('flash::message')
        <x-card class="w-full">
           <Datatable :ajax-route="'{{route('admin.testes.dataTableData')}}'">
                <template v-slot:toolbar>
                    <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                        <i class="fa-solid fa-plus mr-1"></i> {{__('New')}}
                    </button>
                    <button class="btn-primary mx-2">
                        <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> {{__('Filter')}}
                    </button>
                </template>
            </Datatable>
        </x-card>
    </div>
    
    @push('modals')
        @livewire('testes.create')
    @endpush
@endsection

