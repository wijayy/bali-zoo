<?php

namespace App\Livewire\Report;

use App\Models\Transaction as TransactionModel;
use Carbon\Carbon;
use Livewire\Component;

class Transaction extends Component
{
    public string $start_date = '';

    public string $end_date = '';

    public function mount()
    {
        $this->start_date = Carbon::now()->startOfMonth()->toDateString();
        $this->end_date = Carbon::now()->toDateString();
    }

    public function export()
    {
        $this->validateDateRange();

        $transactions = $this->transactionQuery()->get();
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        $filename = 'transaction-report-' . $this->start_date . '-to-' . $this->end_date . '.xls';

        return response()->streamDownload(function () use ($transactions, $startDate, $endDate) {
            echo view('exports.report.transaction', [
                'transactions' => $transactions,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ])->render();
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    public function render()
    {
        return view('livewire.report.transaction', [
            'transactions' => $this->transactionQuery()->get(),
        ])->layout('components.layouts.app', ['title' => 'Transaction Report']);
    }

    private function transactionQuery()
    {
        return TransactionModel::with([
            'user',
            'items.product.category',
            'items.product.supplier',
            'pengiriman',
            'payment',
            'couponUsage.coupon',
        ])
            ->when($this->start_date, fn ($query) => $query->whereDate('created_at', '>=', $this->start_date))
            ->when($this->end_date, fn ($query) => $query->whereDate('created_at', '<=', $this->end_date))
            ->latest();
    }

    private function validateDateRange(): void
    {
        $this->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
    }
}
