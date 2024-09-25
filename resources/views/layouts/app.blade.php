<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        <script>
            function handleInput(event) {
                let input = document.getElementById('barcodeInput');
                
                // When 'Enter' is pressed, trigger the search automatically
                if (event.key === 'Enter') {
                    input.value += ',';
                    Livewire.emit('searchMultipleBarcodes', input.value);
                }
            }
        
            // Auto-trigger search after the debounce (handled by wire:model.live.debounce.2000ms)
            document.getElementById('barcodeInput').addEventListener('input', function() {
                let input = this.value;
                Livewire.emit('searchMultipleBarcodes', input);
            });
        </script>

        @livewireScripts
    </body>
</html>
