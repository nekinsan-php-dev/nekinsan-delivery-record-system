<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class OrderIndex extends Component
{
    public $name;
    public $mobile;
    public $city;
    public $state;
    public $address;
    public $pincode;
    public $product;
    public $barcode = "";

    protected $rules = [
        'name' => 'required|string|max:255',
        'mobile' => 'required|string|max:20',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'pincode' => 'required|string|max:10',
        'product' => 'required',
        'barcode' => 'nullable'
    ];

    public function saveOrder()
    {
        $validatedData = $this->validate();

        Order::create($validatedData);

        $this->reset(['name', 'mobile', 'city', 'state', 'address', 'pincode', 'product']);

        session()->flash('message', 'Order placed successfully!');
    }

    public function render()
    {
        $recentOrders = Order::latest()->take(5)->get();
        return view('livewire.order.order-index', ['recentOrders' => $recentOrders]);
    }
}
