<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class RecentAddedOrders extends Component
{
    protected $listeners = ['orderAdded'];

    public function render()
    {
        $recentOrders = Order::latest()->take(5)->get();
        return view('livewire.order.recent-added-orders',['recentOrders' => $recentOrders]);
    }
}
