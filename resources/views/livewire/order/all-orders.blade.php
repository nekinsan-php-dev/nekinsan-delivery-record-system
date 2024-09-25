<div>
    <div class="max-w-4xl mx-auto">
       @include('order.menu')
      <!-- Datatable -->
      <div class="mt-12 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-500">
          <h3 class="text-2xl font-bold text-white">Recent Orders</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="bg-gray-100 border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
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
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->barcode ?? 'Not Assigned' }}</td>
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

  </script>