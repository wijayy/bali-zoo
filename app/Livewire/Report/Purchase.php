<?php

namespace App\Livewire\Report;

use App\Models\Purchase as PurchaseModel;
use Carbon\Carbon;
use Livewire\Component;

class Purchase extends Component
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

        $purchases = $this->purchaseQuery()->get();
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        $filename = 'purchase-report-' . $this->start_date . '-to-' . $this->end_date . '.xls';

        return response()->streamDownload(function () use ($purchases, $startDate, $endDate) {
            echo view('exports.report.purchase', [
                'purchases' => $purchases,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ])->render();
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    public function render()
    {
        return view('livewire.report.purchase', [
            'purchases' => $this->purchaseQuery()->get(),
        ])->layout('components.layouts.app', ['title' => 'Purchase Report']);
    }

    private function purchaseQuery()
    {
        return PurchaseModel::with([
            'items.product.category',
            'items.product.supplier',
        ])
            ->when($this->start_date, fn ($query) => $query->whereDate('purchase_date', '>=', $this->start_date))
            ->when($this->end_date, fn ($query) => $query->whereDate('purchase_date', '<=', $this->end_date))
            ->latest('purchase_date');
    }

    private function validateDateRange(): void
    {
        $this->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
    }
}
