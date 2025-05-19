@extends('layouts.app')

@section('content')


<div class="p-3 w-full h-full">
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 w-full">
        <Datatable-Agentes :ajax-route="'{{route('admin.agentes.dataTableData')}}'"
            :can-create="false"
            :can-delete="false"
            >
            <template v-slot:toolbar>
                {{-- @can('agentes.create')
                <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                    <i class="fa-solid fa-plus mr-1"></i> Novo
                </button>
                @endcan --}}
                <button class="btn-primary mx-2" onclick="Livewire.dispatch('openFilter')">
                    <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> Filtro
                </button>
            </template>
        </Datatable-Agentes>    
    </div>
</div>

@push('modals')
    @can('agentes.create')
        @livewire('agentes.create')
    @endcan
        @livewire('agentes.filter')
    @endpush
@endsection

@can('agentes.delete')
@push('scripts')
<script>
    function deleteRegister(agente){
            Swal.fire({
                icon: 'info',
                title: "Exclusão de registro",     
                text: agente instanceof Array ? "Tem certeza de que deseja excluir os registros selecionados?": "Tem certeza de que deseja excluir este registro?",
                showCancelButton: true,
                confirmButtonText: "Sim",
                confirmButtonColor: "#27272A",
                cancelButtonColor: "#EA4335",
                cancelButtonText: "Cancelar"     
            }).then((res) => {
                if(res.value){
                    Livewire.dispatch('delete',[agente])
                }
            })
        }
        function restoreRegister(agente){
            Swal.fire({
                icon: 'info',
                title: "Restauração de registro",     
                text: agente instanceof Array ? "Tem certeza de que deseja restaurar os registros selecionados?": "Tem certeza de que deseja restaurar este registro?",
                showCancelButton: true,
                confirmButtonText: "Sim",
                confirmButtonColor: "#27272A",
                cancelButtonColor: "#EA4335",
                cancelButtonText: "Cancelar"     
            }).then((res) => {
                if(res.value){
                    Livewire.dispatch('restore',[agente])
                }
            })
        }
</script>
@endpush
@endcan