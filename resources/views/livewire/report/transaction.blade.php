<div class="p-6 space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Transaction Report</h1>
            <p class="text-sm text-zinc-500">Filter transaksi berdasarkan tanggal dibuat.</p>
        </div>

        <flux:button as href="{{ route('report.index') }}" variant="ghost" wire:navigate>Back to Report</flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:items-end">
            <flux:input wire:model.live="start_date" label="Start Date" type="date" />
            <flux:input wire:model.live="end_date" label="End Date" type="date" />

            <div class="text-sm text-zinc-500">
                Total transaksi
                <div class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $transactions->count() }}</div>
            </div>

            <flux:button wire:click="export" variant="primary" class="md:justify-self-end">Export Excel</flux:button>
        </div>

        @error('end_date')
            <div class="mt-3 text-sm text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50 text-left text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Transaction</th>
                        <th class="px-4 py-3 font-semibold">Date</th>
                        <th class="px-4 py-3 font-semibold">Customer</th>
                        <th class="px-4 py-3 font-semibold">Items</th>
                        <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                        <th class="px-4 py-3 text-right font-semibold">Shipping</th>
                        <th class="px-4 py-3 text-right font-semibold">Discount</th>
                        <th class="px-4 py-3 text-right font-semibold">Total</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-3 font-medium text-zinc-900 dark:text-white">
                                {{ $transaction->transaction_number }}
                            </td>
                            <td class="px-4 py-3">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3">{{ $transaction->user?->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $transaction->items->count() }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ ucfirst($transaction->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-zinc-500">No transaction found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
