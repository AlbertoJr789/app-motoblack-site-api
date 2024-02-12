@extends('layouts.app')

@section('content')

    <div class="p-3 w-full h-full">
        @include('flash::message')
        <x-card class="w-full">
           <Datatable :ajax-route="'{{route('admin.testes.dataTableData')}}'"
                :can-create="@can('testes.create') true @else false @endcan"
                :can-delete="@can('testes.delete') true @else false @endcan"         
                >
                <template v-slot:toolbar>
                    @can('testes.create')
                        <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                            <i class="fa-solid fa-plus mr-1"></i> {{__('New')}}
                        </button>
                    @endcan
                    <button class="btn-primary mx-2" onclick="Livewire.dispatch('openFilter')">
                        <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> {{__('Filter')}}
                    </button>
                </template>
            </Datatable>
        </x-card>
    </div>
    
    @push('modals')
        @can('testes.create')
            @livewire('testes.create')
        @endcan
        @livewire('testes.filter')
    @endpush
@endsection

@can('testes.delete')
    @push('scripts')
        <script>
            function deleteRegister(teste){
                Swal.fire({
                    icon: 'info',
                    title: "{{__('Delete register')}}",     
                    text: teste instanceof Array ? "{{__('Are you sure you want to delete the selected registers?')}}": "{{__('Are you sure you want to delete this register?')}}",
                    showCancelButton: true,
                    confirmButtonText: "{{__('Yes')}}",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "{{__('Cancel')}}"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('delete',[teste])
                    }
                })
            }
            function restoreRegister(teste){
                Swal.fire({
                    icon: 'info',
                    title: "{{__('Restore register')}}",     
                    text: teste instanceof Array ? "{{__('Are you sure you want to restore the selected registers?')}}": "{{__('Are you sure you want to restore this register?')}}",
                    showCancelButton: true,
                    confirmButtonText: "{{__('Yes')}}",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "{{__('Cancel')}}"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('restore',[teste])
                    }
                })
            }
        </script>
    @endpush
@endcan
