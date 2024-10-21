<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class RtoOrders implements OnEachRow, WithHeadingRow
{
    public function onRow($row)
    {
        $userId = Auth::id();

        if (isset($row['barcode']) && !empty($row['barcode'])) {
            $barcodeFromExcel = $row['barcode'];
            $order = Order::where('barcode', $barcodeFromExcel)->first();

            if ($order && $order->status !== 'delivered') {
                $order->rto_at = now(); // Set to current date and time
                $order->update_by = $userId;
                $order->status = 'rto';
                $order->save();
            }
        }
    }
}
