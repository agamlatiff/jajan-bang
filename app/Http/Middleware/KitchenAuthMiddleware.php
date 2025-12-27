<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KitchenAuthMiddleware
{
  /**
   * Kitchen access PIN. In production, store this in .env or database.
   */
  protected string $kitchenPin = '1234'; // Default PIN

  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if already authenticated via session
    if (session('kitchen_authenticated')) {
      return $next($request);
    }

    // If PIN is submitted, validate it
    if ($request->isMethod('post') && $request->has('kitchen_pin')) {
      $submittedPin = $request->input('kitchen_pin');
      $validPin = config('app.kitchen_pin', $this->kitchenPin);

      if ($submittedPin === $validPin) {
        session(['kitchen_authenticated' => true]);
        return redirect()->route('kitchen.dashboard');
      }

      return back()->withErrors(['kitchen_pin' => 'PIN tidak valid. Silakan coba lagi.']);
    }

    // Show login form
    return response()->view('kitchen.auth', [], 403);
  }
}
