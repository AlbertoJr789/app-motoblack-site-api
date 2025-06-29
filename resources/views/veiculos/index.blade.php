@extends('layouts.app')

@section('content')


<div class="p-3 w-full h-full">
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 w-full">
        <Datatable-Veiculos :ajax-route="'{{route('admin.veiculos.dataTableData')}}'"
            :can-create="false"
            :can-delete="@can('veiculos.delete') true @else false @endcan">
            <template v-slot:toolbar>
                {{-- @can('veiculos.create')
                <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                    <i class="fa-solid fa-plus mr-1"></i> Novo
                </button>
                @endcan --}}
                <button class="btn-primary mx-2" onclick="Livewire.dispatch('openFilter')">
                    <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> Filtro
                </button>
            </template>
        </Datatable-Veiculos>
    </div>
</div>

@push('modals')
@can('veiculos.create')
@livewire('veiculos.create')
@endcan
@livewire('veiculos.filter')
@endpush
@endsection

@can('veiculos.delete')
@push('scripts')
<script>
   
    function deleteRegister(veiculo){
                Swal.fire({
                    icon: 'info',
                    title: "Exclusão de registro",     
                    text: veiculo instanceof Array ? "Tem certeza de que deseja excluir os registros selecionados?": "Tem certeza de que deseja excluir este registro?",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "Cancelar"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('delete',[veiculo])
                    }
                })
            }
    function restoreRegister(veiculo){
        Swal.fire({
            icon: 'info',
            title: "Restauração de registro",     
            text: veiculo instanceof Array ? "Tem certeza de que deseja restaurar os registros selecionados?": "Tem certeza de que deseja restaurar este registro?",
            showCancelButton: true,
            confirmButtonText: "Sim",
            confirmButtonColor: "#27272A",
            cancelButtonColor: "#EA4335",
            cancelButtonText: "Cancelar"     
        }).then((res) => {
            if(res.value){
                Livewire.dispatch('restore',[veiculo])
            }
        })
    }
</script>
@endpush
@endcan