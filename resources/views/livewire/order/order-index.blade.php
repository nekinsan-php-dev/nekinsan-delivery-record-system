<div>
  <div class="max-w-7xl mx-auto">
        @include('order.menu')
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-600 to-indigo-600">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-2xl font-bold text-white mb-4 sm:mb-0">Create New Order</h3>
                    <p class="mt-2 text-center text-indigo-100">Fill in the details below to place your custom order</p>
                </div>
            </div>
            @if (session()->has('message'))
                <div class="px-8 py-4 bg-green-100 border-t border-b border-green-200" role="alert">
                    <p class="text-sm text-green-700">{{ session('message') }}</p>
                </div>
            @endif
            <form wire:submit.prevent="saveOrder" class="px-8 py-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" wire:model.defer="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="John Doe">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                        <input type="tel" id="mobile" wire:model.defer="mobile"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="+1 (555) 123-4567">
                        @error('mobile')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" id="city" wire:model.defer="city"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="New York">
                        @error('city')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <input type="text" id="state" wire:model.defer="state"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="NY">
                        @error('state')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street
                            Address</label>
                        <input type="text" id="address" wire:model.defer="address"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="123 Main St, Apt 4B">
                        @error('address')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                        <input type="number" id="pincode" wire:model.defer="pincode"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="10001">
                        @error('pincode')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="product" class="block text-sm font-medium text-gray-700 mb-1">Select
                            Product</label>
                        <select wire:model.defer="product" id="product"
                            class="block w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-indigo-200">
                            <option value="" disabled selected>Select a product</option>
                            @foreach (['Car Sticker', 'Child Tag', 'Pet Tag', 'Doorbell', 'Key Chain', 'Smart Card', 'Bike Sticker', 'Mobile', 'Trolly', 'Laptop', 'Luggage'] as $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('product')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                        <input type="number" id="amount" wire:model.defer="amount"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                            placeholder="10001">
                        @error('amount')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline hover:from-indigo-700 hover:to-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        Place Order
                    </button>
                </div>
            </form>


        </div>

        <!-- Datatable -->
        <livewire:order.recent-added-orders />
    </div>
</div>

<script>
    // This script adds interactivity to the radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[type="radio"]').forEach(r => {
                r.closest('label').classList.remove('border-indigo-500', 'ring-2',
                    'ring-indigo-500');
                r.nextElementSibling.nextElementSibling.classList.add('hidden');
            });
            this.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
            this.nextElementSibling.nextElementSibling.classList.remove('hidden');
        });
    });
</script>
