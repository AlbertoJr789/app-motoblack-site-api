
@php
    $menu = "{{ __('{$config->modelNames->humanPlural}') }}";
    $route = "{{route('admin.{$config->modelNames->camelPlural}.index')}}";
@endphp
@verbatim
@@can('{{$config->modelNames->humanPlural}}.view') @endverbatim @verbatim
<x-menu-item icon="fa-solid fa-pen" @endverbatim route="{!! $route !!}">
        {!! $menu !!} @verbatim
</x-menu-item>@endverbatim
@@endcan


