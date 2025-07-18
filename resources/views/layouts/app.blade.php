<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Moto Black</title>

        <!-- Fonts -->
        <link href="{{asset('css/fonts-bunny.css')}}" rel="stylesheet" />
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


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

        @php
            $preferredLanguage = request()->getPreferredLanguage() ?? 'en_US';
            $translations = Illuminate\Support\Facades\Cache::get('translationsJSON'.$preferredLanguage) ?? '';
        @endphp
        <script>
            window.translations = {!! $translations !!};
            
            window.trans = (key, replace = {}) =>
            {
                let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);
                for (var placeholder in replace) {
                    translation = translation.replace(`:${placeholder}`, replace[placeholder]);
                }
                return translation ?? key;
            }
        </script>

        @stack('scripts')

        @stack('modals')

        @include('sweetalert::alert')

        @livewireScriptConfig
        @vite('resources/js/app.js')
    </body>
</html>
