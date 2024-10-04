<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Barcode;
use App\Models\Order;
use App\Services\FilterOrders;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    protected FilterOrders $filterOrders;

    public function __construct(FilterOrders $filterOrders)
    {
        $this->filterOrders = $filterOrders;
    }

    public function index(Request $request)
    {
        $orders = Order::query();

        // Apply filters using FilterOrders action
        $orders = $this->filterOrders->filter($request, $orders);

        // Handle per-page selection, default to 10
        $perPage = $request->perPage ?? 10;
        $orders = $orders->latest()->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'ordersHtml' => view('order.orders-list', compact('orders'))->render(),
                'paginationHtml' => view('order.pagination', compact('orders'))->render(),
                'hasMorePages' => $orders->hasMorePages(),
                'currentPage' => $orders->currentPage(),
                'lastPage' => $orders->lastPage(),
            ]);
        }

        return view('order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order.allrecords');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status', 'all');

        $query = Order::query();

        if ($startDate && !$endDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->get();

        $currentDate = now()->format('d-m-Y');

        return Excel::download(new OrdersExport($orders), $currentDate . '-orders.xlsx');
    }

    public function assignBarcode(Request $request)
    {
        $request->validate([
            'orderIds' => 'required|array',
            'orderIds.*' => 'exists:orders,id',
        ]);

        $orderIds = $request->orderIds;
        $batchSize = 10; // Process 10 orders at a time
        $processedCount = 0;

        $batch = array_slice($orderIds, 0, $batchSize);
        
        // Fetch the orders that need barcodes
        $orders = Order::whereIn('id', $batch)->get();

        // Fetch available barcodes
        $barcodes = Barcode::where('isAssigned', 0)->limit(count($orders))->get();

        // Ensure we have enough barcodes
        if ($barcodes->count() < $orders->count()) {
            return response()->json([
                'message' => 'Not enough barcodes available',
            ], 400);
        }

        // Loop through orders and assign each a unique barcode
        foreach ($orders as $index => $order) {
            $barcode = $barcodes[$index];  // Get a unique barcode for each order

            // Update the order with the assigned barcode
            $order->update([
                'barcode' => $barcode->barcode,
                'status' => 'dispatched',
                'scanned_at' => now(),
                'assigned_by' => auth()->user()->id,
            ]);

            // Mark the barcode as assigned
            $barcode->update([
                'isAssigned' => 1,
            ]);

            $processedCount++;
        }

        return response()->json([
            'message' => 'Barcodes assigned successfully for this batch',
            'processedCount' => $processedCount,
        ]);
    }

    public function invoice($id)
    {
        $orders = Order::where('id', $id)->get();
        return view('order.invoice', compact('orders'));
    }

    public function invoiceMultiple(Request $request)
    {
        $request->validate([
            'orderIds' => 'required|json',
        ]);

        $orderIds = json_decode($request->orderIds, true);
        
        $orders = Order::whereIn('id', $orderIds)->get();

        return view('order.invoice', compact('orders'));
    }

    public function markDelivered(Order $order)
    {
        $order->update(['status' => 'delivered']);
        return response()->json(['success' => true]);
    }
}
