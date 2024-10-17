@php
    use Carbon\Carbon;
@endphp

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
                    <span
                        class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'dispatched' || $order->status === 'delivered' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        @if ($order->status === 'dispatched' || $order->status === 'delivered')
                            @if ($order->scanned_at)
                                {{ Carbon::parse($order->scanned_at)->format('d-m-Y') }}
                            @else
                                Not Dispatched
                            @endif
                        @else
                            Not Dispatched
                        @endif
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Delivered:</span>
                    <span
                        class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        @if ($order->status === 'delivered')
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
                class="mark-delivered-btn px-4 py-2 rounded-md transition-colors duration-200
                {{ $order->status === 'booked' ? 'bg-white text-indigo-600 border border-indigo-600 hover:bg-indigo-100' : '' }}
                {{ $order->status === 'dispatched' ? 'bg-white text-indigo-600 border border-indigo-600 hover:bg-indigo-100' : '' }}
                {{ $order->status === 'delivered' ? 'bg-green-500 text-white cursor-not-allowed' : '' }}
                {{ $order->status === 'rto' ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : '' }}"
                {{ $order->status === 'delivered' || $order->status === 'rto' ? 'disabled' : '' }}>
                Delivered
            </button>
        </td>
        {{-- print invoice  --}}
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="{{ route('orders.invoice', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Print</a>
        </td>
        {{-- send message on whatsapp --}}
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            @if($order->barcode)
                <a href="https://wa.me/91{{ $order->mobile }}?text=नमस्ते%20{{ urlencode($order->name) }}%2C%0A%0Aआपके%20लिए%20*NEKINSAN*%20से%20एक%20ऑर्डर%20है।%20आपका%20ट्रैकिंग%20आईडी%20{{ urlencode($order->barcode) }}%20है।%0A%0Aअधिक%20जानकारी%20के%20लिए%20हमारी%20वेबसाइट%20देखें%3A%20https%3A%2F%2Fnekinsan.com%2F%0A%0Aआप%20इस%20लिंक%20के%20माध्यम%20से%20अपने%20ऑर्डर%20को%20ट्रैक%20कर%20सकते%20हैं%3A%20https%3A%2F%2Fwww.indiapost.gov.in%2F_layouts%2F15%2Fdop.portal.tracking%2Ftrackconsignment.aspx%0A%0Aइस%20लिंक%20को%20खोलें%20और%20अपना%20ट्रैकिंग%20आईडी%20दर्ज%20करके%20अपने%20ऑर्डर%20को%20ट्रैक%20करें।"
                    target="_blank" 
                    class="text-indigo-600 hover:text-indigo-900">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" width="30px" height="30px"
                        class="inline-block align-middle mr-1">
                        <path fill="#f2faff"
                            d="M7.904,58.665L7.8,58.484c-3.263-5.649-4.986-12.102-4.983-18.66 C2.826,19.244,19.577,2.5,40.157,2.5C50.14,2.503,59.521,6.391,66.57,13.446C73.618,20.5,77.5,29.879,77.5,39.855 c-0.01,20.583-16.76,37.328-37.34,37.328c-6.247-0.003-12.418-1.574-17.861-4.543l-0.174-0.096L2.711,77.636L7.904,58.665z" />
                        <path fill="#788b9c"
                            d="M40.157,3L40.157,3c9.85,0.003,19.105,3.838,26.059,10.799C73.17,20.76,77,30.013,77,39.855 c-0.009,20.307-16.536,36.828-36.855,36.828c-6.149-0.003-12.237-1.553-17.606-4.482l-0.349-0.19l-0.384,0.101l-18.384,4.82 l4.91-17.933l0.11-0.403l-0.209-0.362c-3.22-5.574-4.92-11.94-4.917-18.41C3.326,19.52,19.852,3,40.157,3 M40.157,2 C19.302,2,2.326,18.969,2.317,39.824C2.313,46.49,4.055,53,7.367,58.735L2,78.339l20.06-5.26 c5.526,3.015,11.751,4.601,18.084,4.604h0.016c20.855,0,37.831-16.969,37.84-37.827c0-10.108-3.933-19.613-11.077-26.764 C59.78,5.942,50.28,2.003,40.157,2L40.157,2z" />
                        <path fill="#79ba7e"
                            d="M39.99,70c-5.009-0.003-9.965-1.263-14.332-3.646l-2.867-1.564l-3.159,0.828l-6.482,1.699	l1.659-6.061l0.907-3.312l-1.718-2.974C11.38,50.437,9.997,45.255,10,39.986C10.007,23.453,23.464,10.002,39.997,10	c8.022,0.003,15.558,3.126,21.221,8.793C66.881,24.461,70,31.998,70,40.011C69.992,56.547,56.535,70,39.99,70z" />
                        <path fill="#fff"
                            d="M56.561,47.376c-0.9-0.449-5.321-2.626-6.143-2.924c-0.825-0.301-1.424-0.449-2.023,0.449	c-0.599,0.9-2.322,2.924-2.845,3.523c-0.524,0.599-1.048,0.674-1.948,0.226c-0.9-0.449-3.797-1.4-7.23-4.462	c-2.674-2.382-4.478-5.327-5.001-6.227c-0.524-0.9-0.057-1.385,0.394-1.834c0.403-0.403,0.9-1.051,1.349-1.575	c0.449-0.524,0.599-0.9,0.9-1.5c0.301-0.599,0.151-1.126-0.075-1.575c-0.226-0.449-2.023-4.875-2.773-6.673	c-0.729-1.752-1.472-1.515-2.023-1.542c-0.524-0.027-1.123-0.03-1.722-0.03c-0.599,0-1.575,0.226-2.397,1.126	c-0.822,0.9-3.147,3.074-3.147,7.498s3.222,8.699,3.671,9.298c0.449,0.599,6.338,9.678,15.36,13.571	c2.144,0.924,3.821,1.478,5.125,1.894c2.153,0.684,4.113,0.587,5.664,0.355c1.728-0.259,5.321-2.174,6.067-4.273	c0.75-2.099,0.75-3.899,0.524-4.273C58.06,48.051,57.461,47.825,56.561,47.376z" />
                    </svg>
                    <span class="align-middle">WhatsApp</span>
                </a>
            @else
                <span class="text-gray-400 cursor-not-allowed" title="Barcode not available. Please assign a barcode before sending a message.">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" width="30px" height="30px"
                        class="inline-block align-middle mr-1">
                        <path fill="#f2faff"
                            d="M7.904,58.665L7.8,58.484c-3.263-5.649-4.986-12.102-4.983-18.66 C2.826,19.244,19.577,2.5,40.157,2.5C50.14,2.503,59.521,6.391,66.57,13.446C73.618,20.5,77.5,29.879,77.5,39.855 c-0.01,20.583-16.76,37.328-37.34,37.328c-6.247-0.003-12.418-1.574-17.861-4.543l-0.174-0.096L2.711,77.636L7.904,58.665z" />
                        <path fill="#788b9c"
                            d="M40.157,3L40.157,3c9.85,0.003,19.105,3.838,26.059,10.799C73.17,20.76,77,30.013,77,39.855 c-0.009,20.307-16.536,36.828-36.855,36.828c-6.149-0.003-12.237-1.553-17.606-4.482l-0.349-0.19l-0.384,0.101l-18.384,4.82 l4.91-17.933l0.11-0.403l-0.209-0.362c-3.22-5.574-4.92-11.94-4.917-18.41C3.326,19.52,19.852,3,40.157,3 M40.157,2 C19.302,2,2.326,18.969,2.317,39.824C2.313,46.49,4.055,53,7.367,58.735L2,78.339l20.06-5.26 c5.526,3.015,11.751,4.601,18.084,4.604h0.016c20.855,0,37.831-16.969,37.84-37.827c0-10.108-3.933-19.613-11.077-26.764 C59.78,5.942,50.28,2.003,40.157,2L40.157,2z" />
                        <path fill="#79ba7e"
                            d="M39.99,70c-5.009-0.003-9.965-1.263-14.332-3.646l-2.867-1.564l-3.159,0.828l-6.482,1.699	l1.659-6.061l0.907-3.312l-1.718-2.974C11.38,50.437,9.997,45.255,10,39.986C10.007,23.453,23.464,10.002,39.997,10	c8.022,0.003,15.558,3.126,21.221,8.793C66.881,24.461,70,31.998,70,40.011C69.992,56.547,56.535,70,39.99,70z" />
                        <path fill="#fff"
                            d="M56.561,47.376c-0.9-0.449-5.321-2.626-6.143-2.924c-0.825-0.301-1.424-0.449-2.023,0.449	c-0.599,0.9-2.322,2.924-2.845,3.523c-0.524,0.599-1.048,0.674-1.948,0.226c-0.9-0.449-3.797-1.4-7.23-4.462	c-2.674-2.382-4.478-5.327-5.001-6.227c-0.524-0.9-0.057-1.385,0.394-1.834c0.403-0.403,0.9-1.051,1.349-1.575	c0.449-0.524,0.599-0.9,0.9-1.5c0.301-0.599,0.151-1.126-0.075-1.575c-0.226-0.449-2.023-4.875-2.773-6.673	c-0.729-1.752-1.472-1.515-2.023-1.542c-0.524-0.027-1.123-0.03-1.722-0.03c-0.599,0-1.575,0.226-2.397,1.126	c-0.822,0.9-3.147,3.074-3.147,7.498s3.222,8.699,3.671,9.298c0.449,0.599,6.338,9.678,15.36,13.571	c2.144,0.924,3.821,1.478,5.125,1.894c2.153,0.684,4.113,0.587,5.664,0.355c1.728-0.259,5.321-2.174,6.067-4.273	c0.75-2.099,0.75-3.899,0.524-4.273C58.06,48.051,57.461,47.825,56.561,47.376z" />
                    </svg>
                    <span class="align-middle">WhatsApp</span>
                </span>
            @endif
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