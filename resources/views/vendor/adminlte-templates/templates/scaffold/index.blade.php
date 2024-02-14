@@extends('layouts.app')

@@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
@if($config->options->localized)
                    <h1>@@lang('models/{{ $config->modelNames->camelPlural }}.plural')</h1>
@else
                    <h1>{{ $config->modelNames->humanPlural }}</h1>
@endif
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.create') }}">
@if($config->options->localized)
                         @@lang('crud.add_new')
@else
                        Add New
@endif
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @@include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            {!! $table !!}
        </div>
    </div>

@@endsection

-- MINHA PARTE ---
@@extends('layouts.app')

@@section('content')

    <div class="p-3 w-full h-full">
        <x-card class="w-full">
           <Datatable :ajax-route="'{{route('admin.{!! $config->modelNames->camelPlural !!}.dataTableData')}}'"
                :can-create="@@can('testes.create') true @@else false @@endcan"
                :can-delete="@@can('testes.delete') true @@else false @@endcan"         
                >
                <template v-slot:toolbar>
                    @@can('{!! $config->modelNames->camelPlural !!}.create')
                        <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                            <i class="fa-solid fa-plus mr-1"></i> {{__('New')}}
                        </button>
                    @@endcan
                    <button class="btn-primary mx-2" onclick="Livewire.dispatch('openFilter')">
                        <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> {{__('Filter')}}
                    </button>
                </template>
            </Datatable>
        </x-card>
    </div>
    
    @@push('modals')
        @@can('testes.create')
            @@livewire('testes.create')
        @@endcan
        @@livewire('testes.filter')
    @@endpush
@@endsection

@@can('testes.delete')
    @@push('scripts')
        <script>
            function deleteRegister({{$config->modelNames->camel}}){
                Swal.fire({
                    icon: 'info',
                    title: "{{__('Delete register')}}",     
                    text: {{$config->modelNames->camel}} instanceof Array ? "{{__('Are you sure you want to delete the selected registers?')}}": "{{__('Are you sure you want to delete this register?')}}",
                    showCancelButton: true,
                    confirmButtonText: "{{__('Yes')}}",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "{{__('Cancel')}}"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('delete',[{{$config->modelNames->camel}}])
                    }
                })
            }
            function restoreRegister({{$config->modelNames->camel}}){
                Swal.fire({
                    icon: 'info',
                    title: "{{__('Restore register')}}",     
                    text: {{$config->modelNames->camel}} instanceof Array ? "{{__('Are you sure you want to restore the selected registers?')}}": "{{__('Are you sure you want to restore this register?')}}",
                    showCancelButton: true,
                    confirmButtonText: "{{__('Yes')}}",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "{{__('Cancel')}}"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('restore',[{{$config->modelNames->camel}}])
                    }
                })
            }
        </script>
    @@endpush
@@endcan
