<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:barcode-scanner />
            </div>
        </div>
    </div>
    <x-slot:js>
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
    </x-slot:js>
</x-app-layout>
