<?php

namespace App\Livewire\Pages;

use App\Livewire\Traits\AddToCartTrait;
use App\Livewire\Traits\CategoryFilterTrait;
use App\Models\Category;
use App\Models\Foods;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PromoPage extends Component
{
    use CategoryFilterTrait;
    use AddToCartTrait;

    public $categories;
    public $selectedCategories = [];
    public $items;
    public $title = "Promo";

    public $term = '';
    public $sort = 'popular';
    public $minPrice = 0;
    public $maxPrice = 1000000;
    public $selectedCategory = null;

    public function updatedSelectedCategory($value)
    {
        $this->selectedCategories = $value ? [$value] : [];
    }

    public function mount(Foods $foods)
    {
        $this->categories = Category::cached();
        $this->items = $foods->getPromo();
    }

    #[Layout('components.layouts.page')]
    public function render()
    {
        $filteredProducts = $this->getFilteredItems();

        if ($this->term) {
            $filteredProducts = $filteredProducts->filter(function ($item) {
                return stripos($item->name, $this->term) !== false;
            });
        }

        $filteredProducts = $filteredProducts->filter(function ($item) {
            $p = $item->is_promo ? $item->price_afterdiscount : $item->price;
            return $p >= $this->minPrice && $p <= $this->maxPrice;
        });

        if ($this->sort === 'popular') {
            $filteredProducts = $filteredProducts->sortByDesc('total_sold');
        } elseif ($this->sort === 'newest') {
            $filteredProducts = $filteredProducts->sortByDesc('created_at');
        } elseif ($this->sort === 'price_low') {
            $filteredProducts = $filteredProducts->sortBy(function ($item) {
                return $item->is_promo ? $item->price_afterdiscount : $item->price;
            });
        } elseif ($this->sort === 'price_high') {
            $filteredProducts = $filteredProducts->sortByDesc(function ($item) {
                return $item->is_promo ? $item->price_afterdiscount : $item->price;
            });
        }

        return view('product.promo', [
            'filteredProducts' => $filteredProducts,
        ]);
    }
}
