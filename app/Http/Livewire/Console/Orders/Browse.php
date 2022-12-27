<?php

namespace App\Http\Livewire\Console\Orders;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Shopper\Framework\Models\Shop\Order\Order;

class Browse extends Component
{
    public function render(): View
    {
        return view('livewire.console.orders.browse', [
            'total' => Order::query()->count(),
        ]);
    }
}

