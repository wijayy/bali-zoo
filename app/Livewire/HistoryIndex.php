<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class HistoryIndex extends Component
{

    #[Url(except: '')]
    public $date;

    public $transactions, $title = "Transaction History";

    public function mount()
    {
        $this->date = $this->date ?? date("Y-m-d");
        $this->transactions = Transaction::where('user_id', Auth::user()->id)->whereDate('created_at', $this->date)->get();

        // dd($this->date,$this->transactions);
    }


    public function render()
    {
        return view('livewire.history-index')->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }
}
