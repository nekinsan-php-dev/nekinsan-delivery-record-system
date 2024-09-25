<div class="container mx-auto p-6 space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">Barcode Manager</h1>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
        </svg>
    </div>

    <div class="bg-white rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save" class="flex space-x-2">
                <input type="text" wire:model.defer="newBarcode" placeholder="Enter a barcode"
                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    autofocus>
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save
                </button>
            </form>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="flex space-x-2">
            <div class="flex-grow relative">
                <input type="text" id="barcodeInput" wire:model.live.debounce.1000ms="search"
                    placeholder="Scan or input barcodes separated by commas..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onkeydown="handleInput(event)">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <select wire:model.live="perPage" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-left">
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            Sr. No.</th>
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            ID</th>
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            Barcode</th>
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            Scanned At</th>
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            Current Status</th>
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            RTO Remark</th>
                        <th
                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barcodes as $barcode)
                        <tr class="hover:bg-gray-50">
                            <td class="border-b border-gray-200 px-6 py-4">{{ $loop->index + 1 }}</td>
                            <td class="border-b border-gray-200 px-6 py-4">{{ $barcode->id }}</td>
                            <td class="border-b border-gray-200 px-6 py-4">{{ $barcode->barcode }}</td>
                            <td class="border-b border-gray-200 px-6 py-4">
                                {{ $barcode->created_at->format('d-m-Y') }}
                            </td>
                            <td class="border-b border-gray-200 px-6 py-4">
                                <span
                                    class="px-4 py-3 text-xs font-semibold rounded 
                                    {{ $barcode->status === 'delivered'
                                        ? 'bg-green-100 text-green-800'
                                        : ($barcode->status === 'rto'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-green-700 text-white') }}">
                                    {{ ucfirst($barcode->status) }}
                                </span>
                            </td>
                            <td class="border-b border-gray-200 px-6 py-4">{{ $barcode->rto_remark }}</td>
                            <td class="border-b border-gray-200 px-6 py-4">
                                @if ($barcode->status === 'dispatched')
                                    <button
                                        class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition ease-in-out duration-150">
                                        Delivered
                                    </button>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border-b border-gray-200 px-6 py-4 text-center text-gray-500">
                                No barcodes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4 mr-2">
                {{ $barcodes->links() }}
            </div>
        </div>

        <div x-data="{ successMessage: '', errorMessage: '' }"
            x-on:show-success.window="successMessage = $event.detail; setTimeout(() => successMessage = '', 3000)"
            x-on:show-error.window="errorMessage = $event.detail; setTimeout(() => errorMessage = '', 3000)"
            class="fixed bottom-0 right-0 m-6 space-y-2">
            <div x-show="successMessage" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="p-4 bg-green-700 text-white rounded-lg shadow-lg">
                <span x-text="successMessage"></span>
            </div>
            <div x-show="errorMessage" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="p-4 bg-red-700 text-white rounded-lg shadow-lg">
                <span x-text="errorMessage"></span>
            </div>
        </div>

        @if ($showConfirmation)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Update Barcode Status
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        This barcode was scanned before. Do you want to update its status to "Dispatched to RTO"?
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <label for="rto-remark" class="block text-sm font-medium text-gray-700">RTO Remark</label>
                                    <textarea wire:model.defer="rtoRemark" id="rto-remark" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Enter RTO remark here..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="confirmUpdate" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button wire:click="cancelUpdate" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
