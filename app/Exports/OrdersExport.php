<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements  FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $orders;
    protected $serialNumber = 1;


    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'S.No',   
            'Barcode',
            'Ref',
            'City',
            'Pincode',
            'Name',
            'Address',
            'Mobile',
            'Date',
            'Cod',
        ];
    }

    public function map($order): array
    {
        return [
            $this->serialNumber++,    
            $order->barcode,
            $order->product,
            $order->city,
            $order->pincode,
            $order->name,
            $order->address,
            $order->mobile,
            $order->created_at->format('d-m-Y'),
            $order->amount,
        ];
    }
}
