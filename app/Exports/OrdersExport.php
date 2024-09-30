<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Order::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'Product',
            'Amount',
            'Barcode',
            'Name',
            'Mobile',
            'State',
            'City',
            'Address',
            'Pincode',
            'Cod'
        ];
    }

    public function map($order): array
    {
        return [
            $order->product,
            $order->amount,
            $order->barcode,
            $order->name,
            $order->mobile,
            $order->state,
            $order->city,
            $order->address,
            $order->pincode,
            $order->amount,
        ];
    }
}
