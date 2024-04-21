
@can('pessoas.view')
<x-menu-item icon="fa-solid fa-user-large"  route="{{route('admin.pessoas.index')}}" :active="Route::is('admin.pessoas.index')">
        {{ __('Pessoas') }} 
</x-menu-item>
@endcan

@can('agentes.view')  
<x-menu-item icon="fa-solid fa-user-secret"  route="{{route('admin.agentes.index')}}" :active="Route::is('admin.agentes.index')">
        {{ __('Agentes') }} 
</x-menu-item>
@endcan

@can('veiculos.view')  
<x-menu-item icon="fa-solid fa-car"  route="{{route('admin.veiculos.index')}}" :active="Route::is('admin.veiculos.index')">
        {{ __('Veiculos') }} 
</x-menu-item>
@endcan

@can('passageiros.view')  
<x-menu-item icon="fa-solid fa-user-large"  route="{{route('admin.passageiros.index')}}" :active="Route::is('admin.passageiros.index')">
        {{ __('Passageiros') }} 
</x-menu-item>
@endcan

@can('atividades.view')  
<x-menu-item icon="fa-solid fa-flag-checkered"  route="{{route('admin.atividades.index')}}" :active="Route::is('admin.atividades.index')">
        {{ __('Atividades') }} 
</x-menu-item>
@endcan


