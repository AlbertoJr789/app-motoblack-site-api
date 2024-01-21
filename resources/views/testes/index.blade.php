@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Testes</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.testes.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="p-3 w-full h-full">

        @include('flash::message')

        <x-card class="w-full">
           <Datatable :ajax-route="'{{route('admin.testes.dataTableData')}}'"/>
        </x-card>
    </div>

@endsection
