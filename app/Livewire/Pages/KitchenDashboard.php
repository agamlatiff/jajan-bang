<?php

namespace App\Livewire\Pages;

use App\Enums\OrderStatus;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class KitchenDashboard extends Component
{
  public string $filter = 'active'; // active, all, today

  public function getOrdersProperty()
  {
    $query = Transaction::with('items')
      ->where('payment_status', 'paid')
      ->orderBy('created_at', 'desc');

    return match ($this->filter) {
      'active' => $query->active()->get(),
      'today' => $query->today()->get(),
      default => $query->limit(50)->get(),
    };
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
