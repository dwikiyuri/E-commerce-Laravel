<?php

namespace App\Livewire;

use App\Models\brand;
use App\Models\category;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Home Page - YuriGshop')]
class HomePage extends Component
{
    public function render()
    {
        $brands = brand::where('is_active', 1)->take(8)->get();
        $categories = category::where('is_active', 1)->get();
        return view('livewire.home-page' ,
        [
            'brands' => $brands,
            'categories' => $categories

        ]);
    }
}
