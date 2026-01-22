<?php

namespace App\Livewire\Purchase;

use Livewire\Component;

class Index extends Component
{
    public $purchases;
    public function mount()
    {
        $this->purchases = \App\Models\Purchase::with('items.product')->latest()->get();
    }

    public function render()
    {
        return view('livewire.purchase.index')->layout('components.layouts.app', ['title' => 'Purchase']);
    }
}
