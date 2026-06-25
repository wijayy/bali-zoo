<div class="p-6 space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between print:hidden">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Purchase Report</h1>
            <p class="text-sm text-zinc-500">Filter purchase berdasarkan purchase date.</p>
        </div>

        <flux:button as href="{{ route('report.index') }}" variant="ghost" wire:navigate>Back to Report</flux:button>
    </div>

    <!-- Print Only Header -->
    <div class="hidden print:block border-b border-zinc-200 pb-4 mb-4">
        <h1 class="text-3xl font-bold text-zinc-900">Purchase Report</h1>
        <p class="text-sm text-zinc-600 mt-2">
            Period: {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}
        </p>
        <p class="text-sm text-zinc-600">Total Purchase: {{ $purchases->count() }}</p>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900 print:hidden">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:items-end">
            <flux:input wire:model.live="start_date" label="Start Date" type="date" />
            <flux:input wire:model.live="end_date" label="End Date" type="date" />

            <div class="text-sm text-zinc-500">
                Total purchase
                <div class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $purchases->count() }}</div>
            </div>

            <div class="flex gap-2 md:justify-self-end">
                <flux:button wire:click="export" variant="primary">Export Excel</flux:button>
                <flux:button onclick="window.print()" variant="filled" class="bg-emerald-600 hover:bg-emerald-700 text-white border-none">Export PDF</flux:button>
            </div>
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
                        <th class="px-4 py-3 font-semibold">Purchase</th>
                        <th class="px-4 py-3 font-semibold">Date</th>
                        <th class="px-4 py-3 font-semibold">Items</th>
                        <th class="px-4 py-3 font-semibold">Payment</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 text-right font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td class="px-4 py-3 font-medium text-zinc-900 dark:text-white">
                                {{ $purchase->purchase_number }}
                            </td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $purchase->items->count() }}</td>
                            <td class="px-4 py-3">{{ $purchase->payment_method }}</td>
                            <td class="px-4 py-3">{{ ucfirst($purchase->status) }}</td>
                            <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($purchase->total, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-zinc-500">No purchase found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
