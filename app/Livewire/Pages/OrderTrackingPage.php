<?php

namespace App\Livewire\Pages;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class OrderTrackingPage extends Component
{
  public ?Transaction $transaction = null;
  public string $invoiceNumber = '';
  public bool $notFound = false;

  public function mount(?string $invoice = null)
  {
    if ($invoice) {
      $this->invoiceNumber = $invoice;
      $this->searchOrder();
    }
  }

  public function searchOrder()
  {
    $this->notFound = false;

    if (empty($this->invoiceNumber)) {
      return;
    }

    $this->transaction = Transaction::with('items.food')
      ->where('code', $this->invoiceNumber)
      ->first();

    if (!$this->transaction) {
      $this->notFound = true;
    }
  }

  public function render()
  {
    return view('livewire.pages.order-tracking-page');
  }
}
