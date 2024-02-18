
@php
    $menu = "{{ __('{$config->modelNames->humanPlural}') }}";
    $route = "{{route('admin.{$config->modelNames->camel}.index')}}";
@endphp
@verbatim
<x-menu-item icon="fa-solid fa-pen" @endverbatim route="{!! $route !!}">
        {!! $menu !!} @verbatim
</x-menu-item>@endverbatim


