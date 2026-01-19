<div>
    <flux:container>

        <div class="h-20"></div>

        <flux:text position="center" size="xl">Transaction Overview</flux:text>
        <flux:text position="center">View details of your orders, shipping progress, and payment confirmations all in one
            place.
        </flux:text>

        <div class="grid mt-4 grid-cols-1 md:grid-cols-2  gap-4">
            @foreach ($transactions as $item)
                <div class="rounded-lg bg-white p-4">
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
                        @if (!$item->payment && $item->status == 'ordered')
                            <div class="flex justify-center mt-4 gap-4">
                                <flux:button href="{{ route('payment.index', ['slug' => $item->slug]) }}" variant="primary">Pay</flux:button>
                                <flux:button wire:click='cancel({{ $item->id }})' variant="danger">Cancel</flux:button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            @if ($isLoading)
                <div class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span>Loading...</span>
                </div>
            @elseif($transactions->count() == 0)
                <div class="text-sm text-gray-500">No transactions found.</div>
            @endif
        </div>

        @if ($hasMore)
            <div id="history-load-more" style="height:1px"></div>
        @endif

        <script>
            document.addEventListener('livewire:load', function() {
                let observer;

                function observeSentinel() {
                    const sentinel = document.getElementById('history-load-more');
                    if (!sentinel) return;

                    if (observer) observer.disconnect();

                    observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                Livewire.emit('loadMoreHistory');
                            }
                        });
                    }, {
                        rootMargin: '200px'
                    });

                    observer.observe(sentinel);
                }

                observeSentinel();

                Livewire.hook('message.processed', (message, component) => {
                    observeSentinel();
                });
            });
        </script>

    </flux:container>

    @livewire('newslatter')
</div>
