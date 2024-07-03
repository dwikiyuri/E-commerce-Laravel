<?php

namespace App\Livewire;

use App\Models\order;
use Livewire\Component;
use Livewire\Attributes\Title;
#[Title('Success - YuriGshop')]
class SuccessPage extends Component
{
    public function render()
    {

        $latest_order = order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        return view('livewire.success-page',
    [
        'order' => $latest_order,
    ]);
    }
}
