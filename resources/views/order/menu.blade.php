<div class="flex flex-col sm:flex-row justify-between items-start space-y-4 sm:space-y-0 sm:space-x-4 mb-4">
    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
    <!-- Today's Orders Button -->
    <a href="{{ route('orders.create') }}"
        class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md {{ Route::is('orders.create') ? 'bg-indigo-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Create Order
    </a>
    <!-- View All Orders Button -->
    <a href="{{ route('orders.index') }}"
        class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md {{ Route::is('orders.index') ? 'bg-indigo-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
            </path>
        </svg>
        View All Orders
    </a>
    </div>
    @if (Route::is('orders.index'))
    <form id="dateRangeForm" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 mb-4">
        @csrf
        <div class="flex-grow">
            <input type="text" id="dateRange" name="dateRange" class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Select date range">
            <input type="hidden" id="start_date" name="start_date">
            <input type="hidden" id="end_date" name="end_date">
        </div>
        <div>
            <button type="button" id="applyFilter" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Apply Filter
            </button>
        </div>
        <div>
            <button type="submit" formaction="{{ route('order.export') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Excel
            </button>
        </div>
    </form>
    @endif
</div>
