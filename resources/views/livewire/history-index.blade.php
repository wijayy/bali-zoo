<div>
    <flux:container>

        <div class="h-20"></div>

        <flux:text position="center" size="xl">Transaction Overview</flux:text>
        <flux:text position="center">View details of your orders, shipping progress, and payment confirmations all in one
            place.
        </flux:text>

        <div class="flex gap-4  items-center">
            <div class="">
                <flux:input wire:model='date' type="date"></flux:input>
            </div>
            <div class="">Summary</div>
        </div>

        <div class="grid mt-4 grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($transactions as $item)
                <div class="rounded-lg bg-white p-4">
                    <div class="text-center">
                        {{ $item->transaction_number }}
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 ">
                        <div class=" md:text-sm text-2xs space-y-2">
                            <div class="">{{ $item->pengiriman->name }}</div>
                            <div class="">{{ $item->pengiriman->phone }}</div>
                            <div class="">{{ $item->pengiriman->address }}, {{ $item->pengiriman->village }},
                                {{ $item->pengiriman->district }}, {{ $item->pengiriman->city }},
                                {{ $item->pengiriman->province }}</div>
                        </div>
                        <div class="grid grid-cols-3 sm:col-span-2 gap-2 md:text-sm text-2xs">
                            @foreach ($item->items as $itm)
                                <div class="">{{ $itm->product->name }}</div>
                                <div class="text-center">{{ $itm->qty }}</div>
                                <div class="">Rp. {{ number_format($itm->subtotal, 0, ',', '.') }}</div>
                            @endforeach
                            <div class="">Total</div>
                            <div class="col-span-2">Rp. {{ number_format($item->items->sum('subtotal'), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:container>

    @livewire('newslatter')
</div>
