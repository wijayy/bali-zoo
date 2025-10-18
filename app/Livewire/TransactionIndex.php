<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Attributes\Url;
use Livewire\Component;

class TransactionIndex extends Component
{
    #[Url(except: '')]
    public $date;

    public $transactions, $title = "All Transaction";

    public function mount()
    {
        $this->date = $this->date ?? date("Y-m-d");
        $this->transactions = Transaction::whereDate('created_at', $this->date)->get();

        // dd($this->date,$this->transactions);
    }

    public function render()
    {
        return view('livewire.transaction-index')->layout('layouts.auth', ['title' => $this->title]);
    }
}
