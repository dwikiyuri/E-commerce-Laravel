<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\category;
use Livewire\Attributes\Title;
#[Title('Category - YuriGshop')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = category::where('is_active', 1)->get();
        return view('livewire.categories-page',
        [
            'categories' => $categories

        ]);
    }
}
