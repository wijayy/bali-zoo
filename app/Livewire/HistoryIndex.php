<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class HistoryIndex extends Component
{
    public $transactions;
    public $title = "Order History";
    public $perPage = 10;
    public $page = 1;
    public $hasMore = true;
    public $isLoading = false;

    protected $listeners = [
        'loadMoreHistory' => 'loadMore',
    ];

    public function mount()
    {
        $this->transactions = collect();
        $this->loadTransactions();
    }

    protected function loadTransactions()
    {
        if (!Auth::check()) {
            $this->transactions = collect();
            $this->hasMore = false;
            return;
        }

        $this->isLoading = true;

        $query = Transaction::with(['pengiriman', 'items.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        $chunk = $query->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        $this->transactions = $this->transactions->concat($chunk);

        if ($chunk->count() < $this->perPage) {
            $this->hasMore = false;
        }

        $this->isLoading = false;
    }

    public function loadMore()
    {
        if (!$this->hasMore || $this->isLoading) {
            return;
        }

        $this->page++;
        $this->loadTransactions();
    }

    public function cancel($id) {
        $transaction = Transaction::find($id);
        if ($transaction && $transaction->user_id == Auth::id() && $transaction->status == 'ordered') {
            $transaction->update(['status' => 'canceled']);
        }
        $this->loadTransactions();
    }


    public function render()
    {
        return view('livewire.history-index')->layout('layouts.app', ['title' => $this->title, 'header' => false]);
    }
}
