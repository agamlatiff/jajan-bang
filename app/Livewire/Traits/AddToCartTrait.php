<?php

namespace App\Livewire\Traits;

use App\Models\Foods;

trait AddToCartTrait
{
  public function addItemToCart($foodId)
  {
    $food = Foods::find($foodId);

    if (!$food) {
      $this->dispatch('toast', data: [
        'message1' => 'Error',
        'message2' => 'Produk tidak ditemukan',
        'type' => 'error',
      ]);
      return;
    }

    $cartItems = session('cart_items', []);

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
        'id' => $food->id,
        'name' => $food->name,
        'description' => $food->description,
        'image' => $food->image,
        'price' => $food->price,
        'price_afterdiscount' => $food->price_afterdiscount,
        'percent' => $food->percent,
        'is_promo' => $food->is_promo,
        'categories_id' => $food->categories_id,
        'quantity' => 1,
        'selected' => true,
      ];
    }

    session(['cart_items' => $cartItems]);
    session(['has_unpaid_transaction' => false]);

    $this->dispatch(
      'toast',
      data: [
        'message1' => 'Berhasil ditambahkan',
        'message2' => $food->name,
        'type' => 'success',
      ]
    );
  }
}
