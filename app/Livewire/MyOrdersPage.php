<?php

namespace App\Livewire;

use App\Models\order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('My Orders - YuriGshop')]
class MyOrdersPage extends Component
{
    use WithPagination;
    public function render()
    {
        $my_orders = order::where('user_id', auth()->id())->latest()->paginate(5);
        return view('livewire.my-orders-page',[
            'orders' => $my_orders,
        ]);
    }
}
