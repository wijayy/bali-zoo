<div class="space-y-6">

    {{-- TOPBAR --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div class="flex flex-col md:flex-row gap-3">
            <flux:input wire:model.live='search' type="text" placeholder="Search transaction number..."
                class="min-w-[280px]" />

            <flux:input wire:model.live='date' type="date" />
        </div>

        <div class="flex items-center gap-3">
            <div class="text-sm text-zinc-500">
                Total Transaction
            </div>

            <div
                class="h-11 min-w-11 px-4 rounded-xl bg-black text-white flex items-center justify-center font-semibold">
                {{ $transactions->count() }}
            </div>
        </div>
    </div>

    {{-- TRANSACTIONS --}}
    <div class="space-y-5">

        @foreach ($transactions as $item)
            <div
                class="bg-white border border-zinc-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">

                {{-- HEADER --}}
                <div
                    class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 px-6 py-5 border-b border-zinc-100 bg-zinc-50">

                    <div>
                        <div class="text-xs uppercase tracking-widest text-zinc-400">
                            Transaction Number
                        </div>

                        <div class="text-xl font-bold text-zinc-800">
                            {{ $item->transaction_number }}
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">

                        {{-- STATUS --}}
                        <div
                            class="px-4 py-2 rounded-full text-sm font-semibold
                            @if ($item->status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($item->status == 'paid') bg-blue-100 text-blue-700
                            @elseif($item->status == 'completed') bg-green-100 text-green-700
                            @elseif($item->status == 'cancelled') bg-red-100 text-red-700
                            @else bg-zinc-100 text-zinc-700 @endif">

                            {{ ucfirst($item->status) }}
                        </div>

                        {{-- TOTAL --}}
                        <div class="bg-black text-white rounded-2xl px-5 py-3">

                            <div class="text-xs text-zinc-300">
                                Total Payment
                            </div>

                            <div class="font-bold text-lg">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 p-6">

                    {{-- SHIPPING --}}
                    <div class="xl:col-span-3">

                        <div class="rounded-2xl border border-zinc-200 p-5 h-full">

                            <div class="text-sm font-semibold mb-4 text-zinc-800">
                                Shipping Information
                            </div>

                            <div class="space-y-4">

                                <div>
                                    <div class="font-medium text-zinc-800">
                                        {{ $item->pengiriman->name }}
                                    </div>

                                    <div class="text-sm text-zinc-500">
                                        {{ $item->pengiriman->phone }}
                                    </div>
                                </div>

                                <div class="text-sm leading-relaxed text-zinc-600">

                                    {{ $item->pengiriman->address }},
                                    {{ $item->pengiriman->village }},
                                    {{ $item->pengiriman->district }},
                                    {{ $item->pengiriman->city }},
                                    {{ $item->pengiriman->province }}
                                </div>

                                @if ($item->payment)
                                    @if ($item->pengiriman->awb ?? false)
                                        <div class="bg-green-50 border border-green-200 rounded-xl p-3">

                                            <div class="text-xs text-green-600 mb-1">
                                                AWB / RESI
                                            </div>

                                            <div class="font-semibold text-green-700">
                                                {{ $item->pengiriman->awb }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="pt-2">
                                            <flux:button as
                                                href="{{ route('transaction.request-shipping', ['slug' => $item->slug]) }}"
                                                variant="primary" class="w-full">

                                                Input AWB / RESI
                                            </flux:button>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PRODUCTS --}}
                    <div class="xl:col-span-6">

                        <div class="rounded-2xl border border-zinc-200 overflow-hidden">

                            <div class="px-5 py-4 border-b border-zinc-200 font-semibold text-zinc-800">

                                Ordered Items
                            </div>

                            <div class="divide-y divide-zinc-100">

                                @foreach ($item->items as $itm)
                                    <a href="{{ route('products.show', ['product' => $itm->product->slug]) }}"
                                        class="flex gap-4 p-5 hover:bg-zinc-50 transition">

                                        {{-- IMAGE --}}
                                        <div class="w-24 h-24 rounded-2xl overflow-hidden shrink-0 bg-zinc-100">

                                            <div class="w-full h-full bg-cover bg-center"
                                                style="background-image: url('{{ asset('storage/' . $itm->product->image1) }}')">
                                            </div>
                                        </div>

                                        {{-- PRODUCT --}}
                                        <div class="flex-1 min-w-0">

                                            <div class="font-semibold text-zinc-800 line-clamp-2">

                                                {{ $itm->product->name }}
                                            </div>

                                            <div class="text-sm text-zinc-500 mt-1">
                                                Quantity :
                                                {{ $itm->qty }}
                                            </div>

                                            <div
                                                class="mt-3 inline-flex px-3 py-1 rounded-lg bg-zinc-100 text-xs text-zinc-600">

                                                Rp
                                                {{ number_format($itm->subtotal / $itm->qty, 0, ',', '.') }}
                                                / item
                                            </div>
                                        </div>

                                        {{-- SUBTOTAL --}}
                                        <div class="text-end shrink-0">

                                            <div class="text-xs text-zinc-400 mb-1">
                                                Subtotal
                                            </div>

                                            <div class="font-bold text-zinc-800">

                                                Rp
                                                {{ number_format($itm->subtotal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- PAYMENT --}}
                    <div class="xl:col-span-3">

                        <div class="rounded-2xl border border-zinc-200 p-5 h-full">

                            <div class="font-semibold text-zinc-800 mb-5">
                                Payment Summary
                            </div>

                            <div class="space-y-4 text-sm">

                                <div class="flex justify-between">
                                    <span class="text-zinc-500">
                                        Subtotal
                                    </span>

                                    <span class="font-medium">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                @if ($item->couponUsage)
                                    <div class="flex justify-between text-red-500">
                                        <span>
                                            Discount
                                        </span>

                                        <span>
                                            - Rp {{ number_format($item->discount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex justify-between">
                                    <span class="text-zinc-500">
                                        Shipping
                                    </span>

                                    <span class="font-medium">
                                        Rp {{ number_format($item->shipping_cost, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="border-t border-dashed pt-4 flex justify-between items-center">

                                    <span class="font-semibold text-zinc-800">
                                        Grand Total
                                    </span>

                                    <span class="text-2xl font-bold text-zinc-900">

                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
