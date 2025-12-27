<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PaymentFailurePage extends Component
{
    public $transaction;

    public function mount()
    {
        $invoiceNumber = session('invoice_number');

        if ($invoiceNumber) {
            $this->transaction = \App\Models\Transaction::where('invoice_number', $invoiceNumber)->first();
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('payment.failure');
    }
}
