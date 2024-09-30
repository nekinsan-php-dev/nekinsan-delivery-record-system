<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Barcode;
use Livewire\WithPagination;
use Livewire\Component;

class AllOrders extends Component
{
    use WithPagination;

    public $searchInput;
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    public function updatedSearchInput()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $recentOrders = Order::latest()
            ->when($this->searchInput, function ($query) {
                $query->where('name', 'like', '%' . $this->searchInput . '%')
                      ->orWhere('mobile', 'like', '%' . $this->searchInput . '%')
                      ->orWhere('city', 'like', '%' . $this->searchInput . '%')
                      ->orWhere('product', 'like', '%' . $this->searchInput . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.order.all-orders', [
            'perPage' => $this->perPage,
            'recentOrders' => $recentOrders,
            'startingNumber' => ($recentOrders->currentPage() - 1) * $recentOrders->perPage() + 1,
            'totalOrders' => $recentOrders->total(),
        ]);
    }
}
