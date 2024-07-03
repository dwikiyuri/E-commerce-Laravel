<?php

namespace App\Livewire;

use App\Models\brand;
use App\Models\product;
use Livewire\Component;
use App\Models\category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Products - YuriGshop')]
class ProductsPage extends Component
{
    use WithPagination;
    use LivewireAlert;
    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands= [];
    #[Url]
    public $featured= [];
    #[Url]
    public $on_sale= [];
    #[Url]
    public $price_range= 10000000;
    #[Url]
    public $sort = 'latest';

    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Product adds to cart', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
           ]);
    }

    public function render()
    {
        $productQuery = product::query()->where('is_active', 1);

        if (!empty($this->selected_categories)) {
            # code...
            $productQuery->whereIn('category_id', $this->selected_categories);
        }
        if (!empty($this->selected_brands)) {
            # code...
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }
        if ($this->featured) {
            # code...
            $productQuery->where('is_featured', 1);
        }
        if ($this->on_sale) {
            # code...
            $productQuery->where('on_sale', 1);
        }
        if ($this->price_range) {
            # code...
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }
        if ($this->sort == 'latest') {
            $productQuery->latest();
        }
        if ($this->sort == 'lowtohighprice') {
            $productQuery->orderBy('price');
        }
        if ($this->sort == 'jightolowprice') {
            $productQuery->orderBy('price', 'desc');
        }
        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'brand' => brand::where('is_active', 1)->get(['id', 'slug', 'name']),
            'categories' => category::where('is_active', 1)->get(['id', 'name', 'slug'])
        ]);
    }
}
