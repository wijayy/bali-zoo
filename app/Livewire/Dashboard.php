<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{

    public $topProducts = [], $lastTransactions = [], $product, $transaction, $customer, $pendapatan;
    public array $revenueLabels = [];
    public array $revenueData = [];

    public function mount()
    {
        // Fetch top 5 products based on sales
        $this->topProducts = TransactionItem::select(
            'product_id',
            DB::raw('SUM(qty) as total_sold')
        )
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Fetch last 5 transactions
        $this->lastTransactions = Transaction::latest()->take(5)->get();

        // Fetch total products
        $this->product = Product::count();
        // Fetch total transactions
        $this->transaction = Transaction::count();
        // Fetch total customers
        $this->customer = DB::table('users')->where('is_admin', false)->count();
        // Fetch total revenue
        $this->pendapatan = Transaction::where('status', 'completed')->sum('total');

        $this->loadRevenueChart();
    }

    protected function loadRevenueChart()
    {
        $start = now()->subMonths(11)->startOfMonth();
        $end = now()->endOfMonth();

        $revenues = Transaction::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('SUM(total) as revenue')
        )
            ->where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        // Pastikan 12 bulan selalu ada (walau 0)
        for ($i = 11; $i >= 0; $i--) {
            $monthKey = now()->subMonths($i)->format('Y-m');
            $this->revenueLabels[] = now()->subMonths($i)->format('M Y');
            $this->revenueData[] = (int) ($revenues[$monthKey] ?? 0);
        }
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.auth', [
            'title' => 'Dashboard',
        ]);
    }
}
