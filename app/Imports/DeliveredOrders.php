<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DeliveredOrders implements OnEachRow, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return void
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
            $order->status='delivered';
            $order->save();
        } else {
       
        }
     }
      
       
    }




public function isValidDate($dateString, $format = 'm/d/Y')
{
    $date = Carbon::createFromFormat($format, $dateString);
    
    // Check if the date was parsed successfully and matches the input string
    return $date && $date->format($format) === $dateString;
}
    
    
}
