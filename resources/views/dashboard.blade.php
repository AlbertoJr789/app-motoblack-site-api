<x-app-layout>
    
    @section('content')
        <div class="py-12">
            <div class="px-4">
                @can('agentes.create')
                <x-card>
                    <h4>Agentes pendentes para liberação</h4>
                    @include('dashboard.agentes-pendentes')
                </x-card>
                @endcan
                <div class="my-4"></div>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-6">
                        <x-card>
                            <h2>Ranking de Corridas</h2>
                            <Ranking-Corridas />
                        </x-card>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-card>
                            <h2>Corridas em Andamento</h2>
                            <Corridas-Andamento />
                        </x-card>
                    </div>
                </div>
        </div>
    @endsection

</x-app-layout>
