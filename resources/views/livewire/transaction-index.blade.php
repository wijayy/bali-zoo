<div>
    <div class="flex gap-4 items-center">
        <div class="">
            <flux:input wire:model='date' type="date"></flux:input>
        </div>
        <div class="">Summary</div>
    </div>

    <div class="grid mt-4 grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($transactions as $item)
            <div class="rounded-lg bg-white p-4 border border-black">
                <div class="text-center font-semibold mb-4">
                    {{ $item->transaction_number }}
                </div>
                <div class=" gap-4 ">
                    <flux:separator>Shipping Information</flux:separator>
                    <div class=" md:text-base text-sm space-y-1 mb-4">
                        <div class="">{{ $item->pengiriman->name }} / {{ $item->pengiriman->phone }}</div>
                        <div class="text-xs md:text-sm">{{ $item->pengiriman->address }},
                            {{ $item->pengiriman->village }},
                            {{ $item->pengiriman->district }}, {{ $item->pengiriman->city }},
                            {{ $item->pengiriman->province }}</div>
                    </div>
                    <flux:separator class="mt-4!">Items Information</flux:separator>

                    <div class="grid grid-cols-4 gap-2 items-center py-2 md:text-sm text-2xs">
                        <div class="font-semibold col-span-2">Product</div>
                        <div class="font-semibold text-center">Qty</div>
                        <div class="font-semibold text-end">Subtotal</div>
                    </div>
                    <flux:separator class="my-2" />
                    @foreach ($item->items as $itm)
                        <div class="grid grid-cols-4 gap-2 items-center md:text-sm text-2xs">
                            <a href="{{ route('products.show', ['product' => $itm->product->slug]) }}"
                                class="flex items-center gap-3 col-span-2">
                                <div class="aspect-3/4 w-20 bg-center bg-cover bg-no-repeat"
                                    style="background-image: url({{ asset('storage/' . $itm->product->image1) }})">
                                </div>
                                <div class="">{{ $itm->product->name }}</div>
                            </a>
                            <div class="text-center">{{ $itm->qty }}</div>
                            <div class=" text-end">Rp. {{ number_format($itm->subtotal, 0, ',', '.') }}</div>
                        </div>
                        <flux:separator class="my-2 last:hidden" />
                    @endforeach
                    <flux:separator class="h-1! bg-black! mt-4 rounded-lg" />
                    <div class="flex justify-between">
                        <div class="">Status</div>
                        <div class="col-span-2">{{ ucfirst($item->status) }}
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="">Subtotal</div>
                        <div class="col-span-2">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @if ($item->couponUsage)
                        <div class="flex justify-between">
                            <div class="">Discount ({{ $item->couponUsage->coupon->code }})</div>
                            <div class="col-span-2">- Rp. {{ number_format($item->discount, 0, ',', '.') }}
                            </div>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <div class="">Shipping</div>
                        <div class="col-span-2">Rp. {{ number_format($item->shipping_cost, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="">Total</div>
                        <div class="col-span-2">Rp. {{ number_format($item->total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
