<?php

namespace App\Http\Middleware;

use App\Models\Foods;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCartIntegrity
{
  /**
   * Verify that cart prices match current database prices
   * This prevents price tampering through session manipulation
   */
  public function handle(Request $request, Closure $next): Response
  {
    $cartItems = session('cart_items', []);

    if (empty($cartItems)) {
      return $next($request);
    }

    $foodIds = collect($cartItems)->pluck('id')->toArray();
    $foods = Foods::whereIn('id', $foodIds)->get()->keyBy('id');

    $updatedCart = [];
    $pricesChanged = false;

    foreach ($cartItems as $item) {
      // Skip if item doesn't have required 'id' key
      if (!isset($item['id'])) {
        $pricesChanged = true;
        continue;
      }

      $food = $foods->get($item['id']);

      if (!$food) {
        // Food no longer exists, remove from cart
        $pricesChanged = true;
        continue;
      }

      // Calculate expected price
      $expectedPrice = $food->price;
      $expectedDiscountedPrice = $food->is_promo
        ? $food->price * (1 - ($food->percent / 100))
        : null;

      // Verify and update prices if changed
      if ($item['price'] != $expectedPrice) {
        $item['price'] = $expectedPrice;
        $pricesChanged = true;
      }

      if ($expectedDiscountedPrice && $item['price_afterdiscount'] != $expectedDiscountedPrice) {
        $item['price_afterdiscount'] = $expectedDiscountedPrice;
        $pricesChanged = true;
      }

      // Ensure quantity is within limits
      $item['quantity'] = max(1, min(99, (int) $item['quantity']));

      $updatedCart[] = $item;
    }

    if ($pricesChanged) {
      session(['cart_items' => $updatedCart]);
      session()->flash('cart_updated', 'Beberapa harga dalam keranjang telah diperbarui.');
    }

    return $next($request);
  }
}
