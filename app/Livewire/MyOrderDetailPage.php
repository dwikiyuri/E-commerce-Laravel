<?php

namespace App\Livewire;

use App\Models\order;
use App\Models\address;
use Livewire\Component;
use App\Models\orderItem;
use Livewire\Attributes\Title;

#[Title('Order Detail Page - YuriGshop')]
class MyOrderDetailPage extends Component
{
    public $order_id;
    public function mount($order_id){
        $this->order_id = $order_id;
    }
    public function render()
    {
        $order_items = orderItem::with('product')->where('order_id', $this->order_id)->get();
        $address = address::where('order_id', $this->order_id)->first();
        $order = order::where('id', $this->order_id)->first();

        return view('livewire.my-order-detail-page',[
            'order_items' => $order_items,
            'address' => $address,
            'order' => $order,
        ]);
    }
}
