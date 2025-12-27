<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Foods;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class DetailPage extends Component
{
    public $categories;
    public $matchedCategory;
    public $food;
    public $title = "Favorite";

    public function mount(Foods $foods, $id)
    {
        $this->categories = Category::cached();

        $this->food = $foods->getFoodDetails($id)->first();

        if (empty($this->food)) {
            abort(404);
        }

        $this->matchedCategory = collect($this->categories)->firstWhere('id', $this->food->categories_id);
    }

    use \App\Livewire\Traits\AddToCartTrait;

    public function addToCart()
    {
        $this->addItemToCart($this->food->id);
    }

    public function orderNow()
    {
        $this->addItemToCart($this->food->id);
        return redirect()->route('payment.checkout');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('product.details');
    }
}
