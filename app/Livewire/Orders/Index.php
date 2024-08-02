<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Http\Repositories\OrdersRepository;
use App\Models\Order;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $ordersRepository;

    public $searchInputText = '';

    public function __construct()
    {
        $this->ordersRepository = new OrdersRepository();
    }

    public function render()
    {
        $ordersQuery = Order::query();

        if (!empty($this->searchInputText)) {
            $ordersQuery->where('client_name', 'like', '%' . $this->searchInputText . '%')
                ->orWhere('phone_number', 'like', '%' . $this->searchInputText . '%')
                ->with('product')
                ->paginate(5);
        }

        return view('livewire.orders.index', [
            'orders' => $ordersQuery
                ->with('product')
                ->paginate(5)
                
        ]);
    }
}
