<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PaymentSuccessPage extends Component
{
    public $transaction;

    public function mount()
    {
        $invoiceNumber = session('invoice_number');

        if ($invoiceNumber) {
            $this->transaction = \App\Models\Transaction::where('invoice_number', $invoiceNumber)->first();
        }

        // Keep invoice_number for a bit or maybe we don't need to clear it yet if we just read it into a property?
        // The original code cleared: 'external_id', 'has_unpaid_transaction', 'cart_items', 'payment_token'
        // It did NOT clear 'invoice_number' explicitly in the array, so it might persist.
        // Let's keep the original clearing logic but ensure we have the transaction.

        session()->forget(['external_id', 'has_unpaid_transaction', 'cart_items', 'payment_token']);
        session()->save();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('payment.success');
    }
}
