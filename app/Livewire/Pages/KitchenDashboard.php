<?php

namespace App\Livewire\Pages;

use App\Enums\OrderStatus;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class KitchenDashboard extends Component
{
  public string $filter = 'active'; // active, pending, confirmed, preparing, ready, delivered

  public function getOrdersProperty()
  {
    $query = Transaction::with('items.food')
      ->where('payment_status', 'paid')
      ->orderBy('created_at', 'asc'); // Oldest first for kitchen

    if ($this->filter === 'active') {
      return $query->active()->get();
    }

    return $query->where('order_status', $this->filter)->get();
  }

  public function getCountsProperty()
  {
    $baseQuery = Transaction::where('payment_status', 'paid');

    return [
      'active' => (clone $baseQuery)->active()->count(),
      'pending' => (clone $baseQuery)->where('order_status', OrderStatus::PENDING->value)->count(),
      'confirmed' => (clone $baseQuery)->where('order_status', OrderStatus::CONFIRMED->value)->count(),
      'preparing' => (clone $baseQuery)->where('order_status', OrderStatus::PREPARING->value)->count(),
      'ready' => (clone $baseQuery)->where('order_status', OrderStatus::READY->value)->count(),
    ];
  }

  public function updateStatus(int $orderId, string $status)
  {
    $order = Transaction::findOrFail($orderId);
    $newStatus = OrderStatus::from($status);

    if ($order->updateOrderStatus($newStatus)) {
      $this->dispatch('status-updated', orderId: $orderId, status: $status);
    }
  }

  public function confirmOrder(int $orderId)
  {
    $this->updateStatus($orderId, OrderStatus::CONFIRMED->value);
  }

  public function startPreparing(int $orderId)
  {
    $this->updateStatus($orderId, OrderStatus::PREPARING->value);
  }

  public function markReady(int $orderId)
  {
    $this->updateStatus($orderId, OrderStatus::READY->value);
  }

  public function markDelivered(int $orderId)
  {
    $this->updateStatus($orderId, OrderStatus::DELIVERED->value);
  }

  public function cancelOrder(int $orderId)
  {
    $this->updateStatus($orderId, OrderStatus::CANCELLED->value);
  }

  public function render()
  {
    return view('livewire.pages.kitchen-dashboard', [
      'orders' => $this->orders,
    ]);
  }
}
