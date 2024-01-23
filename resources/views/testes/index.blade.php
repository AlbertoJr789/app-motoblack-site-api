@extends('layouts.app')

@section('content')

    <div class="p-3 w-full h-full">
        @include('flash::message')
        <x-card class="w-full">
            <div class="sm:float-left sm:mb-0 sm:text-start text-center">
                {{-- href="{{ route('admin.testes.create') }}" --}}
                <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                    <i class="fa-solid fa-plus mr-1"></i> {{__('New')}}
                </button>
                <button class="btn-primary mx-2">
                    <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> {{__('Filter')}}
                </button>
            </div>
           <Datatable :ajax-route="'{{route('admin.testes.dataTableData')}}'"/>
        </x-card>
    </div>

    @push('modals')
        @livewire('testes.create')
    @endpush
@endsection
