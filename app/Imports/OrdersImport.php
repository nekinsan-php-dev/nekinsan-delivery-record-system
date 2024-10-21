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
        // dd($row);
        return new Order([
            'name' => $row['name'] ?? '',
            'mobile' => $row['mobile'] ?? $row['addrmobile'] ?? '',
            'city' => $row['city'] ?? $row['City'] ?? '',
            'state' => $row['state'] ?? $row['add3'] ?? '',
            'address' => $row['address'] ?? $row['add1'] ?? '',
            'pincode' => $row['pincode'] ?? $row['pincode'] ?? '',
            'product' => $row['product'] ?? $row['ref'] ?? '',
            'amount' => $row['amount'] ?? $row['pice'] ?? '',
            'barcode' => $row['barcode'] ?? $row['barcode'] ?? '',
            'created_by'=>Auth::id()
        ]);
    }
}
