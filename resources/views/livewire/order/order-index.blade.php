<div>
    <div class="max-w-4xl mx-auto">
       @include('order.menu')
      <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="px-6 py-8 bg-gradient-to-r from-indigo-600 to-blue-500">
          <h2 class="text-3xl font-extrabold text-center text-white">Create Your Order</h2>
          <p class="mt-2 text-center text-indigo-100">Fill in the details below to place your custom order</p>
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
              <input type="text" id="name" wire:model.defer="name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="John Doe">
              @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
              <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
              <input type="tel" id="mobile" wire:model.defer="mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="+1 (555) 123-4567">
              @error('mobile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
          </div>
      
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
              <input type="text" id="city" wire:model.defer="city" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="New York">
              @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
              <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
              <input type="text" id="state" wire:model.defer="state" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="NY">
              @error('state') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
          </div>
      
          <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
            <input type="text" id="address" wire:model.defer="address" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="123 Main St, Apt 4B">
            @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
          </div>
      
          <div>
            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
            <input type="text" id="pincode" wire:model.defer="pincode" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="10001">
            @error('pincode') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
          </div>
      
          <div>
            <span class="block text-sm font-medium text-gray-700 mb-2">Choose Your Product</span>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              @foreach(['car_sticker' => 'Car Sticker', 'bike_sticker' => 'Bike Sticker', 'trolly' => 'Trolly', 'keychain' => 'Keychain'] as $value => $label)
                <label class="relative flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:border-indigo-500 transition-colors duration-200">
                  <input type="radio" wire:model.defer="product" value="{{ $value }}" class="sr-only">
                  <span class="flex-1 text-sm font-medium text-gray-700">{{ $label }}</span>
                  <svg class="w-5 h-5 text-indigo-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                </label>
              @endforeach
            </div>
            @error('product') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
          </div>
      
          <div>
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline hover:from-indigo-700 hover:to-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
              Place Order
            </button>
          </div>
        </form>
            
        
      </div>
  
      <!-- Datatable -->
      <div class="mt-12 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-500">
          <h3 class="text-2xl font-bold text-white">Recent Orders</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($recentOrders as $order)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->mobile }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->city }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $order->product)) }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                      {{ ucfirst($order->status) }}
                    </span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    // This script adds interactivity to the radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.querySelectorAll('input[type="radio"]').forEach(r => {
          r.closest('label').classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500');
          r.nextElementSibling.nextElementSibling.classList.add('hidden');
        });
        this.closest('label').classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
        this.nextElementSibling.nextElementSibling.classList.remove('hidden');
      });
    });
  </script>