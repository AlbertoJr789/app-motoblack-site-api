<Datatable-Agentes :ajax-route="'{{route('admin.agentes.dataTableData')}}'"
                    :can-create="@can('agentes.create') true @else false @endcan"
                    :can-delete="@can('agentes.delete') true @else false @endcan"
                    :filter-options="(d) => {
                        d.activeFilter = false
                    }"
                    >
                    </Datatable-Agentes>    

@push('modals')
    @livewire('agentes.create')
@endpush


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
    </script>
@endpush