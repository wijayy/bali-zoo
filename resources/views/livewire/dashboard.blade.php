<div class="space-y-6">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Total Sales</p>
            <h2 class="text-2xl font-semibold mt-1">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Orders</p>
            <h2 class="text-2xl font-semibold mt-1">{{ $transaction }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Customers</p>
            <h2 class="text-2xl font-semibold mt-1">{{ $customer }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Products</p>
            <h2 class="text-2xl font-semibold mt-1">{{ $product }}</h2>
        </div>
    </div>

    {{-- Sales Overview --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Revenue Growth (Last 12 Months)</h3>
        <div class="h-64 flex items-center justify-center text-gray-400">
            {{-- Chart placeholder --}}
            <canvas id="revenueChart"></canvas>
         

        </div>
    </div>

    {{-- Bottom Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Orders --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="py-2">Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($lastTransactions as $item)
                            <tr>
                                @php
                                    $statusColor = match ($item->status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'ordered' => 'bg-yellow-100 text-yellow-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <td class="py-2">{{ $item->transaction_number }}</td>
                                <td>{{ $item->pengiriman->name }}</td>
                                <td>
                                    <span class="px-2 py-1 text-xs  rounded {{ $statusColor }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Top Products</h3>

            <ul class="space-y-4">
                @foreach ($topProducts as $item)
                    <li class="flex justify-between">
                        <span>{{ $item->product->name }}</span>
                        <span class="font-medium">{{ $item->total_sold }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('livewire:navigated', initRevenueChart);
document.addEventListener('DOMContentLoaded', initRevenueChart);

function initRevenueChart() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($revenueLabels),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueData),
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    ticks: {
                        callback: value =>
                            'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
}
</script>


</div>
