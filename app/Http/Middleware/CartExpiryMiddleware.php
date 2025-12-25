<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartExpiryMiddleware
{
  /**
   * Cart expiry time in minutes (2 hours)
   */
  public const CART_EXPIRY_MINUTES = 120;

  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next): Response
  {
    $cartCreatedAt = session('cart_created_at');
    $cartItems = session('cart_items', []);

    // If there's a cart but no timestamp, set it now
    if (!empty($cartItems) && !$cartCreatedAt) {
      session(['cart_created_at' => now()]);
    }

    // Check if cart has expired
    if ($cartCreatedAt && now()->diffInMinutes($cartCreatedAt) > self::CART_EXPIRY_MINUTES) {
      // Clear expired cart
      session()->forget(['cart_items', 'cart_created_at', 'has_unpaid_transaction']);

      // If on cart or checkout page, redirect with message
      if ($request->routeIs('product.cart', 'payment.checkout')) {
        return redirect()->route('home')->with('toast', [
          'message1' => 'Keranjang Kedaluwarsa',
          'message2' => 'Keranjang belanja Anda telah kedaluwarsa setelah 2 jam.',
          'type' => 'warning',
        ]);
      }
    }

    return $next($request);
  }
}
