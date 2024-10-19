<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RtoOrders implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow($row)
    {
       $userId =Auth::id();
     if(isset($row['barcode'])){
        $barcodeFromExcel = $row['barcode'];
        $order = Order::where('barcode', $barcodeFromExcel)->first();
        if ($order) {
            $order->delivered_at ='2024-02-12';
            $order->update_by = $userId;
            $order->status='RTO';
            $order->save();
        } else {
       
        }
     }
    }   
}
