
@php
    $menu = "{{ __('{$config->modelNames->humanPlural}') }}";
@endphp
@verbatim
<x-menu-item icon="fa-solid fa-pen">@endverbatim
        {!! $menu !!} @verbatim
</x-menu-item>@endverbatim


