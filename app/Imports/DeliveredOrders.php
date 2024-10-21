<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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

       if (isset($row['date'])) {
        $excelDate = $row['date'];

        // Convert Excel serial date to Carbon date
        $date = Carbon::createFromFormat('Y-m-d', Date::excelToDateTimeObject($excelDate)->format('Y-m-d'));
        $formattedDate = $date->format('Y-m-d');

       }else{
        $formattedDate ="";
       }
    
     if(isset($row['barcode'])){
        $barcodeFromExcel = $row['barcode'];
        $order = Order::where('barcode', $barcodeFromExcel)->first();
        if ($order) {
            $order->delivered_at =$formattedDate;
            $order->update_by = $userId;
            $order->status='delivered';
            $order->save();
        } else {
       
        }
     }
      
       
    }

    
    
}
