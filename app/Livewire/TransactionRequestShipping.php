<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class TransactionRequestShipping extends Component
{
    #[Validate('required|string')]
    public $awb;

    public $transaction;

    public function mount($slug)
    {
        $this->transaction = \App\Models\Transaction::where('slug', $slug)->firstOrFail();
    }

    public function save() {
        $this->validate();

        // for simplicity, we just update the AWB and set status to 'picked-up'
        // in a real app, you would have more complex logic and validation here
        $pengiriman = $this->transaction->pengiriman;
        if (!$pengiriman) {
            session()->flash('error', 'Shipping information not found for this transaction.');
            return;
        }

        $pengiriman->awb = $this->awb;
        $pengiriman->status = 'picked-up';
        $pengiriman->save();

        session()->flash('success', "AWB updated and shipping status transaction {$this->transaction->transaction_number} set to picked-up.");
        return redirect()->route('transaction.index');
    }

    public function render()
    {
        return view('livewire.transaction-request-shipping')
            ->layout('layouts.auth', ['title' => 'Input AWB / RESI']);
    }
}
