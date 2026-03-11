<flux:container>
    <div class="h-20"></div>
    <div class="max-w-3xl mx-auto space-y-6 mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="font-semibold mb-2">Transaction {{ $transaction->transaction_number }}</div>
            <div class="text-sm text-gray-600 mb-1">Status: {{ ucfirst($transaction->status) }}</div>
            @if ($transaction->payment)
                <div class="text-sm text-gray-600 mb-4">
                    Payment: {{ ucfirst($transaction->payment->status) }}
                    ({{ $transaction->payment->metode_pembayaran }})
                </div>
            @else
                <div class="text-sm text-gray-600 mb-4">Payment: -</div>
            @endif

            @if (!$transaction->payment && $transaction->status == 'ordered')
                <div class="mt-2">
                    <flux:button wire:click="cancel" variant="danger" size="sm">Cancel Order</flux:button>
                </div>
            @endif

            <flux:separator text="Shipping Information"></flux:separator>
            <div class="space-y-1 text-sm my-4">
                <div>{{ $transaction->pengiriman->name }} / {{ $transaction->pengiriman->phone }}</div>
                <div class="text-xs">
                    {{ $transaction->pengiriman->address }}, {{ $transaction->pengiriman->village }},
                    {{ $transaction->pengiriman->district }}, {{ $transaction->pengiriman->city }},
                    {{ $transaction->pengiriman->province }}
                </div>
            </div>

            <flux:separator text="Items"></flux:separator>
            <div class="space-y-2 mt-2 mb-4">
                @foreach ($transaction->items as $itm)
                    <div class="grid grid-cols-4 gap-2 items-center text-xs md:text-sm">
                        <a href="{{ route('products.show', ['product' => $itm->product->slug]) }}"
                            class="flex items-center gap-3 col-span-2">
                            <div class="aspect-3/4 w-20 bg-center bg-cover bg-no-repeat"
                                style="background-image: url({{ asset('storage/' . $itm->product->image1) }})"></div>
                            <div>{{ $itm->product->name }}</div>
                        </a>
                        <div class="text-center">{{ $itm->qty }}</div>
                        <div class="text-end">Rp. {{ number_format($itm->subtotal, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>

            <flux:separator text="Order Summary"></flux:separator>
            <div class="space-y-1 text-sm mt-2">
                <div class="flex justify-between">
                    <div>Subtotal ({{ $transaction->items->count() }} items)</div>
                    <div>Rp. {{ number_format($transaction->subtotal, 0, ',', '.') }}</div>
                </div>
                <div class="flex justify-between">
                    <div>Shipping</div>
                    <div>Rp. {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</div>
                </div>
                @if ($transaction->couponUsage)
                    <div class="flex justify-between">
                        <div>Coupon</div>
                        <div>{{ $transaction->couponUsage->coupon->code }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div>Discount</div>
                        <div>- Rp. {{ number_format($transaction->discount, 0, ',', '.') }}</div>
                    </div>
                @endif
                <flux:separator></flux:separator>
                <div class="flex justify-between font-semibold mt-2 mb-4">
                    <div>Total</div>
                    <div>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <flux:separator text="Tracking"></flux:separator>
            <div class="text-sm space-y-1 mt-2">
                <div>Status pengiriman: {{ ucfirst(optional($transaction->pengiriman)->status ?? '-') }}</div>
                @if (optional($transaction->pengiriman)->awb)
                    <div>AWB: <span class="font-mono">{{ $transaction->pengiriman->awb }}</span></div>
                @endif
                @if (optional($transaction->pengiriman)->resi)
                    <div>Resi: <span class="font-mono">{{ $transaction->pengiriman->resi }}</span></div>
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
                    @if (optional($transaction->pengiriman)->awb)
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
    </div>

    @livewire('newslatter')
</flux:container>
