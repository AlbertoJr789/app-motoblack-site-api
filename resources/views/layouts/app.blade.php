<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Moto Black') }}</title>

        <!-- Fonts -->
        <link href="{{asset('css/fonts-bunny.css')}}" rel="stylesheet" />
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        
        <x-sidebar-menu />
        
        <div class="min-h-screen sm:ml-20 sm:mb-0 mb-20 bg-gray-100">
            
            @livewire('navigation-menu')
            
            <x-banner />
            
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow ml-5">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <script>
            window.translations = {!! Cache::get('translationsJSON') !!};
            window.trans = (key, replace = {}) =>
            {
                let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);
                for (var placeholder in replace) {
                    translation = translation.replace(`:${placeholder}`, replace[placeholder]);
                }
                return translation;
            }
        </script>

        @stack('scripts')

        @stack('modals')

        @livewireScripts
        @vite('resources/js/app.js')
    </body>
</html>
