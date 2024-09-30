
@forelse ($orders as $order)
    <tr wire:key="{{ $order->id }}" class="hover:bg-gray-50 transition-colors duration-200">
        <td class="px-6 py-4 whitespace-nowrap">
            <input type="checkbox" name="order" value="{{ $order->id }}"
                data-has-barcode="{{ $order->barcode !== null && $order->barcode !== '' ? 'true' : 'false' }}"
                class="selectRecord rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="space-y-2">
                <div class="flex items-center">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Dispatched:</span>
                    <span class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'dispatched' || $order->status === 'delivered' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        @if($order->status === 'dispatched' || $order->status === 'delivered')
                            {{ $order->created_at->format('d-m-Y') }}
                        @else
                            Not Dispatched
                        @endif
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Delivered:</span>
                    <span class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        @if($order->status === 'delivered')
                            {{ $order->created_at->format('d-m-Y') }}
                        @else
                            Not Delivered
                        @endif
                    </span>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ $order->barcode ?? 'Not Assigned' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ ucfirst(str_replace('_', ' ', $order->product)) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span
    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'rto' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
    {{ Str::upper($order->status) }}
</span>

        </td>
        {{-- mark delivered  --}}
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button onclick="markDelivered({{ $order->id }})" data-id="{{ $order->id }}"
                class="px-4 py-2 rounded-md transition-colors duration-200
                {{ $order->status === 'booked' ? 'bg-white text-indigo-600 border border-indigo-600 hover:bg-indigo-100' : '' }}
                 {{ $order->status === 'dispatched' ? 'bg-white text-indigo-600 border border-indigo-600 hover:bg-indigo-100' : '' }}
                {{ $order->status === 'delivered' ? 'bg-green-500 text-white cursor-not-allowed' : '' }}
                {{ $order->status === 'rto' ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : '' }}"
                {{ $order->status === 'delivered' || $order->status === 'rto' ? 'disabled' : '' }}
            >
                Delivered
            </button>
        </td>
        {{-- print invoice  --}}
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="{{ route('orders.invoice', $order->id) }}"
                class="text-indigo-600 hover:text-indigo-900">Print</a>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ $order->name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $order->mobile }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $order->city }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $order->state }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $order->address }}
        </td>
        

    </tr>
@empty
    <tr>
        <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
            No orders available.
        </td>
    </tr>
@endforelse
