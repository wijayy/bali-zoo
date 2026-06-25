<div class="space-y-6">

    {{-- TOPBAR --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div class="flex flex-col md:flex-row gap-3">
            <flux:input wire:model.live='search' type="text" placeholder="Search transaction number..." />

            <flux:input wire:model.live='date' type="date" />
        </div>

        <div class="text-sm text-zinc-500">
            Total Transactions :
            <span class="font-semibold text-zinc-800">
                {{ $transactions->count() }}
            </span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-zinc-200 rounded-3xl overflow-hidden">

        {{-- HEADER --}}
        <div
            class="hidden md:grid grid-cols-15 gap-4 px-6 py-4 bg-zinc-50 border-b border-zinc-200 text-sm font-semibold text-zinc-600">

            <div class="col-span-3">
                Transaction Number
            </div>
            <div class="col-span-2 text-center">
                Transaction Time
            </div>

            <div class="col-span-2 text-center">
                Items
            </div>

            <div class="col-span-2 text-end">
                Subtotal
            </div>

            <div class="col-span-2 text-end">
                Shipping
            </div>

            <div class="col-span-2 text-end">
                Total
            </div>

            <div class="col-span-2 text-center">
                Action
            </div>
        </div>

        {{-- BODY --}}
        <div class="divide-y divide-zinc-100">

            @foreach ($transactions as $item)
                <div class="grid grid-cols-1 md:grid-cols-15 gap-4 px-6 py-5 hover:bg-zinc-50 transition">

                    {{-- TRANSACTION --}}
                    <div class="md:col-span-3">

                        <div class="md:hidden text-xs text-zinc-400 mb-1">
                            Transaction Number
                        </div>

                        <div class="font-semibold text-zinc-800">
                            {{ $item->transaction_number }}
                        </div>

                        <div class="mt-2">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium

                                @if ($item->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($item->status == 'paid')
                                    bg-blue-100 text-blue-700
                                @elseif($item->status == 'completed')
                                    bg-green-100 text-green-700
                                @elseif($item->status == 'cancelled')
                                    bg-red-100 text-red-700
                                @else
                                    bg-zinc-100 text-zinc-700 @endif
                            ">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-span-2 text-center">
                        {{ $item->created_at->format('d M Y, H:i') }}
                    </div>

                    {{-- ITEMS --}}
                    <div class="md:col-span-2 md:text-center flex md:block justify-between">

                        <div class="md:hidden text-sm text-zinc-500">
                            Items
                        </div>

                        <div class="font-medium text-zinc-800">
                            {{ $item->items->count() }} Item
                        </div>
                    </div>

                    {{-- SUBTOTAL --}}
                    <div class="md:col-span-2 md:text-end flex md:block justify-between">

                        <div class="md:hidden text-sm text-zinc-500">
                            Subtotal
                        </div>

                        <div class="font-medium text-zinc-700">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- SHIPPING --}}
                    <div class="md:col-span-2 md:text-end flex md:block justify-between">

                        <div class="md:hidden text-sm text-zinc-500">
                            Shipping
                        </div>

                        <div class="text-zinc-700">
                            Rp {{ number_format($item->shipping_cost, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- TOTAL --}}
                    <div class="md:col-span-2 md:text-end flex md:block justify-between">

                        <div class="md:hidden text-sm text-zinc-500">
                            Total
                        </div>

                        <div class="font-bold text-zinc-900">
                            Rp {{ number_format($item->total, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- ACTION --}}
                    <div class="md:col-span-2 gap-2 flex md:justify-center">
                        <flux:button size="sm" variant="primary" wire:click="show('{{ $item->id }}')">
                            Show
                        </flux:button>
                        @if (!$item->pengiriman?->awb && $item->payment && $item->payment?->status == 'paid')
                            <flux:button as href="{{ route('transaction.request-shipping', ['slug' => $item->slug]) }}"
                                variant="primary" size="sm" color="emerald" class="ho">Input RESI
                            </flux:button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if ($showModal && $selectedTransaction)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white w-full max-w-6xl rounded-3xl overflow-hidden shadow-2xl max-h-[90vh] overflow-y-auto">
                {{-- HEADER --}} <div
                    class="flex items-center justify-between px-6 py-5 border-b border-zinc-200 sticky top-0 bg-white z-10">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-zinc-400"> Transaction Detail </div>
                        <div class="text-2xl font-bold text-zinc-800"> {{ $selectedTransaction->transaction_number }}
                        </div>
                    </div> <button wire:click="$set('showModal', false)"
                        class="w-10 h-10 rounded-full hover:bg-zinc-100 text-xl"> ✕ </button>
                </div> {{-- CONTENT --}} <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 p-6">
                    {{-- SHIPPING --}} <div class="xl:col-span-3">
                        <div class="border border-zinc-200 rounded-2xl p-5 h-full">
                            <div class="font-semibold text-zinc-800 mb-5"> Shipping Information </div>
                            <div class="space-y-4">
                                <div>
                                    <div class="font-medium text-zinc-800">
                                        {{ $selectedTransaction->pengiriman->name }}
                                    </div>
                                    <div class="text-sm text-zinc-500"> {{ $selectedTransaction->pengiriman->phone }}
                                    </div>
                                </div>
                                <div class="text-sm leading-relaxed text-zinc-600">
                                    {{ $selectedTransaction->pengiriman->address }},
                                    {{ $selectedTransaction->pengiriman->village }},
                                    {{ $selectedTransaction->pengiriman->district }},
                                    {{ $selectedTransaction->pengiriman->city }},
                                    {{ $selectedTransaction->pengiriman->province }} </div>

                            </div>
                        </div>
                    </div> {{-- ITEMS --}}
                    <div class="xl:col-span-6 space-y-4">

                        <div class="border border-zinc-200 rounded-2xl overflow-hidden">
                            <div class="px-5 py-4 border-b border-zinc-200 font-semibold text-zinc-800"> Ordered Items
                            </div>
                            <div class="divide-y divide-zinc-100">
                                @foreach ($selectedTransaction->items as $itm)
                                    <div class="flex gap-4 p-5"> {{-- IMAGE --}} <div
                                            class="w-24 h-24 rounded-2xl overflow-hidden shrink-0 bg-zinc-100">
                                            <div class="w-full h-full bg-cover bg-center"
                                                style="background-image: url('{{ asset('storage/' . $itm->product->image1) }}')">
                                            </div>
                                        </div> {{-- PRODUCT --}} <div class="flex-1">
                                            <div class="font-semibold text-zinc-800"> {{ $itm->product->name }} </div>
                                            <div class="text-sm text-zinc-500 mt-1"> Quantity : {{ $itm->qty }}
                                            </div>
                                            <div class="mt-3 inline-flex px-3 py-1 rounded-lg bg-zinc-100 text-xs"> Rp
                                                {{ number_format($itm->subtotal / $itm->qty, 0, ',', '.') }} / item
                                            </div>
                                        </div> {{-- SUBTOTAL --}} <div class="text-end">
                                            <div class="text-xs text-zinc-400 mb-1"> Subtotal </div>
                                            <div class="font-bold text-zinc-800"> Rp
                                                {{ number_format($itm->subtotal, 0, ',', '.') }} </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- <flux:separator text="Tracking"></flux:separator> --}}
                        @if (optional($selectedTransaction->pengiriman)->awb)

                            <div class="border border-zinc-200 rounded-2xl overflow-hidden ">
                                <div class="px-5 py-4 border-b border-zinc-200 font-semibold text-zinc-800">Tracking
                                </div>
                                <div class="p-4">
                                    @if (optional($selectedTransaction->pengiriman)->awb)
                                        <div>AWB: <span
                                                class="font-mono">{{ $selectedTransaction->pengiriman->awb }}</span>
                                        </div>
                                    @endif
                                    @if (optional($selectedTransaction->pengiriman)->resi)
                                        <div>Resi: <span
                                                class="font-mono">{{ $selectedTransaction->pengiriman->resi }}</span>
                                        </div>
                                    @endif

                                    {{-- waybill tracking from Rajaongkir --}}
                                    @if ($trackingData)
                                        <flux:separator text="Waybill Status"></flux:separator>

                                        @if ($isSample)
                                            <div class="text-xs text-gray-500 mb-1">(using sample/bypass data)</div>
                                        @endif

                                        @php
                                            $result = data_get($trackingData, 'rajaongkir.result');
                                            $manifest = collect(data_get($result, 'manifest', []))->reverse()->values();
                                            $summary = data_get($result, 'summary', []);
                                        @endphp

                                        <div class="space-y-2 text-sm">

                                            {{-- SUMMARY --}}
                                            @if ($summary)
                                                <div class="font-semibold">
                                                    Status: {{ $summary['status'] ?? '-' }}
                                                </div>

                                                @if (!empty($summary['pod_date']))
                                                    <div class="text-xs text-gray-600">
                                                        POD:
                                                        {{ \Carbon\Carbon::parse($summary['pod_date'] . ' ' . $summary['pod_time'])->format('d M Y H:i') }}
                                                    </div>
                                                @endif
                                            @endif

                                            {{-- TIMELINE --}}
                                            @if ($manifest->count())
                                                <ul class="border-l-2 border-gray-300 pl-4 mt-3">

                                                    @foreach ($manifest as $entry)
                                                        @php
                                                            $dateTime = $entry['manifest_date'];
                                                        @endphp

                                                        <li class="mb-4 relative flex gap-4 items-center">

                                                            <div
                                                                class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">
                                                                {{ $loop->iteration }}
                                                            </div>
                                                            <div class="">
                                                                <div class="text-xs text-gray-500">
                                                                    {{ \Carbon\Carbon::parse($dateTime)->format('d M Y H:i') }}
                                                                </div>

                                                                <div class="font-medium">
                                                                    {{ $entry['manifest_description'] }}
                                                                </div>

                                                                @if (!empty($entry['city_name']))
                                                                    <div class="text-xs text-gray-500">
                                                                        {{ $entry['city_name'] }}
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </li>
                                                    @endforeach

                                                </ul>
                                            @else
                                                <div class="text-xs text-gray-500">
                                                    No manifest records available.
                                                </div>
                                            @endif

                                        </div>

                                        {{-- reload button --}}
                                        @if (optional($selectedTransaction->pengiriman)->awb)
                                            <div class="mt-3">
                                                <flux:button size="xs" wire:click="loadTracking">
                                                    Reload real data
                                                </flux:button>
                                            </div>
                                        @endif

                                    @endif

                                    {{-- stepper/timeline --}}
                                    @if (count($trackingSteps))
                                        <div class="mt-4">
                                            <div class="flex items-center">
                                                @foreach ($trackingSteps as $key => $label)
                                                    <div class="flex items-center flex-1">
                                                        <div
                                                            class="w-8 h-8 flex items-center justify-center rounded-full text-xs font-semibold {{ $currentTrackingStep >= $loop->index ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                                            {{ $loop->index + 1 }}
                                                        </div>
                                                        @if (!$loop->last)
                                                            <div
                                                                class="flex-1 h-0.5 {{ $currentTrackingStep > $loop->index ? 'bg-blue-600' : 'bg-gray-200' }}">
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex justify-between mt-2 text-xs">
                                                @foreach ($trackingSteps as $label)
                                                    <div class="flex-1 text-center">{{ $label }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>



                    {{-- PAYMENT --}}
                    <div class="xl:col-span-3">
                        <div class="border border-zinc-200 rounded-2xl p-5">
                            <div class="font-semibold text-zinc-800 mb-5"> Payment Summary </div>
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between"> <span class="text-zinc-500"> Status </span> <span
                                        class="font-semibold"> {{ ucfirst($selectedTransaction->status) }} </span>
                                </div>
                                <div class="flex justify-between"> <span class="text-zinc-500"> Subtotal </span>
                                    <span>
                                        Rp {{ number_format($selectedTransaction->subtotal, 0, ',', '.') }} </span>
                                </div>
                                @if ($selectedTransaction->couponUsage)
                                    <div class="flex justify-between text-red-500"> <span> Discount </span> <span> - Rp
                                            {{ number_format($selectedTransaction->discount, 0, ',', '.') }} </span>
                                    </div>
                                @endif
                                <div class="flex justify-between"> <span class="text-zinc-500"> Shipping
                                    </span> <span> Rp
                                        {{ number_format($selectedTransaction->shipping_cost, 0, ',', '.') }}
                                    </span> </div>
                                <div class="border-t pt-4 flex justify-between items-center"> <span
                                        class="font-semibold text-zinc-800"> Grand Total </span> <span
                                        class="text-2xl font-bold text-zinc-900"> Rp
                                        {{ number_format($selectedTransaction->total, 0, ',', '.') }} </span>
                                </div>
                            </div>
                            @if (
                                !$selectedTransaction->pengiriman?->awb &&
                                    $selectedTransaction->payment &&
                                    $selectedTransaction->payment?->status == 'paid')
                                <div class="mt-6">
                                    <flux:button as
                                        href="{{ route('transaction.request-shipping', ['slug' => $selectedTransaction->slug]) }}"
                                        variant="primary" class="w-full"> Input AWB / RESI </flux:button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
