@extends('layouts.app')

@section('content')


<div class="p-3 w-full h-full">
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 w-full">
    <Datatable-Atividades :ajax-route="'{{route('admin.atividades.dataTableData')}}'">
            <template v-slot:toolbar>
                {{-- @can('atividades.create')
                <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                    <i class="fa-solid fa-plus mr-1"></i> Novo
                </button>
                @endcan --}}
                <button class="btn-primary mx-2" onclick="Livewire.dispatch('openFilter')">
                    <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> Filtro
                </button>
            </template>
        </Datatable-Atividades>    
</div>
</div>

@push('modals')
    @livewire('atividades.filter')
@endpush
@endsection
