<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Moto Black') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <main>
            <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
                {{ $slot }}
            </div>
        </main>

        <script>
            window.translations = {!! Cache::get('translationsJSON'.request()->getPreferredLanguage()) ?? '' !!};
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
        {{-- @livewireScripts --}}
        @livewireScriptConfig
        @vite('resources/js/app.js')

    </body>
</html>
