<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Attributes\Url;
use Livewire\Component;

class TransactionIndex extends Component
{
    #[Url(except: '')]
    public $date, $search = '';

    public $transactions, $title = "All Transaction";

    public function mount()
    {
        // $this->transactions = Transaction::whereDate('created_at', $this->date)->get();
        $this->transactions = $this->getTransaction();

        // dd($this->date,$this->transactions);

    }

    public function updatedDate() {
        $this->transactions = $this->getTransaction();
    }

    public function updatedSearch() {
        $this->transactions = $this->getTransaction();
    }

    public function getTransaction() {
        return Transaction::filters(['date' => $this->date, 'number' => $this->search])->get();
    }

    public function render()
    {
        return view('livewire.transaction-index')->layout('layouts.auth', ['title' => $this->title]);
    }
}
