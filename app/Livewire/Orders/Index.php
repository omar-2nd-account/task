<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchInputText = '';

    public function render()
    {
        $ordersQuery = Order::query();

        if (!empty($this->searchInputText)) {
            $ordersQuery->where('client_name', 'like', '%' . $this->searchInputText . '%')
                ->orWhere('phone_number', 'like', '%' . $this->searchInputText . '%')
                ->with('product')
                ->paginate(10);
        }

        return view('livewire.orders.index', [
            'orders' => $ordersQuery
                ->with('product')
                ->paginate(10)
                
        ]);
    }
}
