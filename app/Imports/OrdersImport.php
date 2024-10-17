<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
class OrdersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Order([
            'name' => $row['name'],
            'mobile' => $row['mobile'], 
            'city' => $row['city'], 
            'state' => $row['state'], 
            'address' => $row['address'], 
            'pincode' => $row['pincode'], 
            'product' => $row['product'], 
            'amount' => $row['amount'], 
            'barcode' => '',
            'created_by'=>Auth::id()
        ]);
    }
}
