<?php

namespace App\Livewire\Traits;

trait CartManagement
{
    public const MAX_QUANTITY = 99;
    public const MIN_QUANTITY = 1;

    public function increment($index)
    {
        if ($this->cartItems[$index]['quantity'] >= self::MAX_QUANTITY) {
            $this->dispatch('toast', data: [
                'message1' => 'Batas maksimum',
                'message2' => 'Maksimal 99 item per produk',
                'type' => 'warning',
            ]);
            return;
        }
        $this->cartItems[$index]['quantity']++;
        $this->hasUnpaidTransaction = false;
        $this->updateTotals();
    }

    public function decrement($index)
    {
        if ($this->cartItems[$index]['quantity'] <= self::MIN_QUANTITY) {
            return;
        }
        $this->cartItems[$index]['quantity']--;
        $this->hasUnpaidTransaction = false;
        $this->updateTotals();
    }

    public function updateTotals()
    {
        $this->subtotal = array_sum(array_map(function ($item) {
            $price = $item['is_promo'] ? $item['price_afterdiscount'] : $item['price'];
            return $price * $item['quantity'];
        }, $this->cartItems));

        $this->tax = $this->subtotal * 0.11;

        $this->total = $this->subtotal + $this->tax;
    }
}
