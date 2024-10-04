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
                    @include('order.menu') 

                    <div class="mt-4 flex space-x-4">
                        <button id="assignButton"
                            class="hidden bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                            Assign Barcode Number (<span id="selectedCount">0</span>)
                        </button>
                        <form id="invoiceForm" action="{{ route('orders.invoice-multiple') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="orderIds" id="invoiceOrderIds">
                            <button id="printInvoiceButton" type="submit"
                                class="hidden bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                                Generate & Print Invoice (<span id="selectedInvoiceCount">0</span>)
                            </button>
                        </form>
                    </div>

                    <div class="mt-2 mb-2">
                        <div class="barcodeAssigningProgressBar hidden rounded w-full p-2">
                            <div class="w-full bg-gray-200 rounded-full h-6 dark:bg-gray-700 relative overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full text-xs font-medium text-blue-100 text-center p-0.5 leading-none transition-all duration-500 ease-in-out" style="width: 0%">0%</div>
                            </div>
                            <div class="progress-text text-sm mt-2">Assigning barcodes...</div>
                        </div>
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

                // Initialize Flatpickr for date range
                flatpickr("#dateRange", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    onClose: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) {
                            $('#start_date').val(formatDate(selectedDates[0]));
                            $('#end_date').val(formatDate(selectedDates[1]));
                            fetchOrders(1);
                        }
                    }
                });

                function formatDate(date) {
                    return date.toISOString().split('T')[0];
                }

                function fetchOrders(page = 1) {
                    const searchQuery = $('#searchInput').val();
                    const perPage = $('#perPage').val();
                    const status = $('#status').val();
                    const startDate = $('#start_date').val();
                    const endDate = $('#end_date').val();

                    $.ajax({
                        url: '/orders',
                        data: {
                            search: searchQuery,
                            perPage: perPage,
                            status: status,
                            start_date: startDate,
                            end_date: endDate,
                            page: page
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
                        checkbox.prop('checked', isChecked);
                    });
                    updateButtonVisibility();
                    updateSelectedCount();
                });

                function updateSelectedCount() {
                    const selectedWithoutBarcode = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === false;
                    }).length;
                    const selectedWithBarcode = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === true;
                    });
                    $('#selectedCount').text(selectedWithoutBarcode);
                    $('#selectedInvoiceCount').text(selectedWithBarcode.length);

                    // Update hidden field with selected order IDs
                    const selectedOrderIds = selectedWithBarcode.map(function() {
                        return $(this).val();
                    }).get();
                    $('#invoiceOrderIds').val(JSON.stringify(selectedOrderIds));
                }

                function updateButtonVisibility() {
                    const selectedWithoutBarcode = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === false;
                    }).length;
                    const selectedWithBarcode = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === true;
                    }).length;

                    if (selectedWithoutBarcode > 0) {
                        $('#assignButton').removeClass('hidden');
                    } else {
                        $('#assignButton').addClass('hidden');
                    }

                    if (selectedWithBarcode > 0) {
                        $('#printInvoiceButton').removeClass('hidden');
                    } else {
                        $('#printInvoiceButton').addClass('hidden');
                    }
                }

                // Add event listener for individual checkboxes
                $(document).on('change', '#ordersTableBody input[type="checkbox"]', function() {
                    updateButtonVisibility();
                    updateSelectedCount();
                });

                // Initial call to set correct state
                updateButtonVisibility();
                updateSelectedCount();

                $('#assignButton').on('click', function() {
                    const selectedOrders = $('#ordersTableBody input[type="checkbox"]:checked').filter(function() {
                        return $(this).data('has-barcode') === false;
                    }).map(function() {
                        return $(this).val();
                    }).get();

                    if (selectedOrders.length === 0) {
                        alert('No orders selected for barcode assignment.');
                        return;
                    }

                    // Show progress bar
                    $('.barcodeAssigningProgressBar').removeClass('hidden');
                    updateProgress(0, 'Starting barcode assignment...');

                    let processedCount = 0;
                    const totalOrders = selectedOrders.length;

                    function assignBarcodes(orderIds) {
                        $.ajax({
                            url: '/orders/assign-bar-code',
                            method: 'POST',
                            data: {
                                orderIds: orderIds,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                processedCount += response.processedCount || 0;
                                const progress = (processedCount / totalOrders) * 100;
                                updateProgress(progress, `Assigned ${processedCount} of ${totalOrders} barcodes...`);

                                if (processedCount < totalOrders) {
                                    // If there are more orders to process, call the function again
                                    assignBarcodes(selectedOrders.slice(processedCount));
                                } else {
                                    // All orders processed
                                    updateProgress(100, 'Barcode assignment completed!');
                                    setTimeout(() => {
                                        $('.barcodeAssigningProgressBar').addClass('hidden');
                                        fetchOrders(); // Refresh the order list
                                    }, 2000);
                                }
                            },
                            error: function(xhr) {
                                updateProgress(0, 'Error: ' + xhr.responseJSON.message);
                                setTimeout(() => {
                                    $('.barcodeAssigningProgressBar').addClass('hidden');
                                }, 3000);
                            }
                        });
                    }

                    // Start the barcode assignment process
                    assignBarcodes(selectedOrders);
                });

                function updateProgress(percentage, message) {
                    $('.barcodeAssigningProgressBar .bg-blue-600').css('width', percentage + '%');
                    $('.barcodeAssigningProgressBar .bg-blue-600').text(Math.round(percentage) + '%');
                    $('.barcodeAssigningProgressBar .progress-text').text(message);
                }

                // Add this function to handle marking an order as delivered
                window.markDelivered = function(orderId) {
                    if (confirm('Are you sure you want to mark this order as delivered?')) {
                        $.ajax({
                            url: `/orders/${orderId}/mark-delivered`,
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Order marked as delivered successfully');
                                    fetchOrders(); // Refresh the order list
                                } else {
                                    alert('Failed to mark order as delivered');
                                }
                            },
                            error: function() {
                                alert('An error occurred while marking the order as delivered');
                            }
                        });
                    }
                };

            });
        </script>

    </x-slot:js>
</x-app-layout>