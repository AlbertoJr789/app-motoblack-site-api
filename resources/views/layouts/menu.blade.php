
@can('pessoas.view')
<x-menu-item icon="fa-solid fa-user-large"  route="{{route('admin.pessoas.index')}}">
        {{ __('Pessoas') }} 
</x-menu-item>
@endcan

@can('agentes.view')  
<x-menu-item icon="fa-solid fa-user-secret"  route="{{route('admin.agentes.index')}}">
        {{ __('Agentes') }} 
</x-menu-item>
@endcan

@can('veiculos.view')  
<x-menu-item icon="fa-solid fa-car"  route="{{route('admin.veiculos.index')}}">
        {{ __('Veiculos') }} 
</x-menu-item>
@endcan

@can('passageiros.view')  
<x-menu-item icon="fa-solid fa-user-large"  route="{{route('admin.passageiros.index')}}">
        {{ __('Passageiros') }} 
</x-menu-item>
@endcan

@can('corridas.view')  
<x-menu-item icon="fa-solid fa-flag-checkered"  route="{{route('admin.corridas.index')}}">
        {{ __('Corridas') }} 
</x-menu-item>
@endcan


