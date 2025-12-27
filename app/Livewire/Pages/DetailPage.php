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

    public function addToCart()
    {
        $cartItems = session('cart_items', []);
        $foodId = $this->food->id;

        // Find existing item index safely
        $existingItemIndex = false;
        foreach ($cartItems as $index => $item) {
            if (isset($item['id']) && $item['id'] == $foodId) {
                $existingItemIndex = $index;
                break;
            }
        }

        if ($existingItemIndex !== false) {
            $cartItems[$existingItemIndex]['quantity'] += 1;
        } else {
            $cartItems[] = [
                'id' => $this->food->id,
                'name' => $this->food->name,
                'description' => $this->food->description,
                'image' => $this->food->image,
                'price' => $this->food->price,
                'price_afterdiscount' => $this->food->price_afterdiscount,
                'percent' => $this->food->percent,
                'is_promo' => $this->food->is_promo,
                'categories_id' => $this->food->categories_id,
                'quantity' => 1,
                'selected' => true,
            ];
        }

        session(['cart_items' => $cartItems]);
        session(['has_unpaid_transaction' => false]);

        $this->dispatch(
            'toast',
            data: [
                'message1' => 'Item added to cart',
                'message2' => $this->food->name,
                'type' => 'success',
            ]
        );
    }

    public function orderNow()
    {
        $this->addToCart();
        return redirect()->route('payment.checkout');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('product.details');
    }
}
