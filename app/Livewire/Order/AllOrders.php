<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class AllOrders extends Component
{
    public function render()
    {
        $recentOrders = Order::latest()->paginate(10);
        return view('livewire.order.all-orders',['recentOrders' => $recentOrders]);
    }
}
