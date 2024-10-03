<!-- resources/views/order/index.blade.php -->

<x-app-layout>
    <x-slot:css>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    </x-slot:css>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Orders
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="max-w-7xl mx-auto">
                    @include('order.menu') <!-- Ensure this exists and is correct -->

                    <div class="mt-4 flex">
                        <button id="assignButton"
                            class="hidden bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                            Assign Barcode Number (<span id="selectedCount">0</span>)
                        </button>
                        <button id="printInvoiceButton"
                            class="hidden bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                            Generate & Print Invoice
                        </button>
                    </div>

                    <!-- Datatable -->
                    <div class="mt-4 bg-white rounded-lg shadow-xl overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-600 to-indigo-600">
                            <div class="flex flex-col sm:flex-row justify-between items-center">
                                <h3 class="text-2xl font-bold text-white mb-4 sm:mb-0">All Orders</h3>
                                <div
                                    class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">

                                    <!-- Search -->
                                    <input type="text" id="searchInput" placeholder="Search orders..."
                                        class="px-4 py-2 rounded-md focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300">

                                    <select id="perPage"
                                        class="perPage block w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="10">10 per page</option>
                                        <option value="20">20 per page</option>
                                        <option value="50">50 per page</option>
                                        <option value="100">100 per page</option>
                                        <option value="500">500 per page</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 mb-2">
                            <div class="barcodeAssigningProgressBar hidden rounded w-full p-2">
                                <div
                                    class="w-full bg-gray-200 rounded-full h-6 dark:bg-gray-700 relative overflow-hidden">
                                    <div class="bg-blue-600 h-full rounded-full text-xs font-medium text-blue-100 text-center p-0.5 leading-none transition-all duration-500 ease-in-out"
                                        style="width: 0%">0%</div>
                                </div>
                                <div class="progress-text text-sm mt-2">Assigning barcodes...</div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="selectAllRecords"
                                                class="selectAllRecords rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sr. No.</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dates</th>

                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Barcode</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Print Invoice</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mobile</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            City</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            State</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Address</th>


                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="ordersTableBody">
                                    @include('order.orders-list') <!-- Include only table rows -->
                                </tbody>
                            </table>
                        </div>

                        <div id="pagination" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            @include('order.pagination') <!-- Ensure this is correctly included -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Functionality -->
    <x-slot:js>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            $(document).ready(function() {
                const selectAllRecords = $('#selectAllRecords');
                function fetchOrders(page = 1) {
                    const searchQuery = $('#searchInput').val();
                    const perPage = $('#perPage').val();
                    const status = $('#status').val();

                    $.ajax({
                        url: '{{ route('orders.index') }}',
                        data: {
                            search: searchQuery,
                            perPage: perPage,
                            status: status,
                        },
                        success: function(response) {
                            $('#ordersTableBody').html(response.ordersHtml);
                            $('#pagination').html(response.paginationHtml);
                        },
                        error: function() {
                            alert('Error fetching orders');
                        }
                    });
                }

                fetchOrders(1);

                $('#searchInput').on('input', function() {
                    fetchOrders(1);
                });

                $('#perPage').on('change', function() {
                    fetchOrders(1);
                });

                $('#status').on('change', function() {
                    fetchOrders(1);
                });

                selectAllRecords.on('change', function() {
                    const isChecked = $(this).is(':checked');
                    $('#ordersTableBody tr').each(function() {
                        const checkbox = $(this).find('td:first-child input[type="checkbox"]');
                        if (checkbox.data('has-barcode') === false) {
                            checkbox.prop('checked', isChecked);
                        }
                    });
                    updateAssignButtonVisibility();
                    updateSelectedCount();
                });

                function updateSelectedCount() {
                    const selectedCount = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === false;
                    }).length;
                    $('#selectedCount').text(selectedCount);
                }

                function updateAssignButtonVisibility() {
                    const selectedCount = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === false;
                    }).length;
                    if (selectedCount > 0) {
                        $('#assignButton').removeClass('hidden');
                    } else {
                        $('#assignButton').addClass('hidden');
                    }
                }

                // Add event listener for individual checkboxes
                $(document).on('change', '#ordersTableBody input[type="checkbox"]', function() {
                    updateAssignButtonVisibility();
                    updateSelectedCount();
                });

                // Initial call to set correct state
                updateAssignButtonVisibility();
                updateSelectedCount();
            });
        </script>

    </x-slot:js>
</x-app-layout>
