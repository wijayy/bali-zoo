<div class=" space-y-2 text-sm">

    <div class="flex justify-between">
        <div class=" font-semibold text-lg">{{ $transaction->transaction_number }}</div>
    </div>
    <flux:separator></flux:separator>
    <div class="text-sm">{{ $transaction->pengiriman->name }} / {{ $transaction->pengiriman->phone }}</div>
    <div class="text-xs">{{ $transaction->pengiriman->address }}</div>

    <flux:separator text="Products"></flux:separator>
    <div class="">
        @foreach ($transaction->items as $key => $itm)
            <div class="grid grid-cols-4 text-xs items-center"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="flex items-center col-span-2 gap-2">
                    <div class="size-20 rounded bg-center bg-cover bg-no-repeat"
                        style="background-image: url({{ asset("storage/{$itm->product->image1}") }})">
                    </div>
                    <div class="">
                        <div class="font-semibold">{{ $itm->product->name }}</div>
                        <div class="text-xs md:text-sm">{{ $itm->product->category->name }}</div>
                    </div>
                </div>
                <div class="text-center">
                    {{ $itm->qty }} Pcs
                </div>
                <div class="text-center">Rp.
                    {{ number_format($itm->subtotal, 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>
    <flux:separator text="Order summary"></flux:separator>
    <div class="">
        <div class="flex justify-between items-center">
            <div class="">Subtotal ({{ $transaction->items->count() }} items)</div>
            <div class="">Rp. {{ number_format($transaction->subtotal, 0, ',', '.') }}</div>
        </div>
        <div class="flex justify-between items-center">
            <div class="">Shipping</div>
            <div class="">Rp. {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</div>
        </div>
        @if ($transaction->couponUsage)
            <div class="flex justify-between items-center">
                <div class="">Coupon</div>
                <div class="">{{ $transaction->couponUsage->coupon->code }}</div>
            </div>
            <div class="flex justify-between items-center">
                <div class="">Discount</div>
                <div class="">Rp. {{ number_format($transaction->discount, 0, ',', '.') }}</div>
            </div>
        @endif
        <flux:separator></flux:separator>
        <div class="flex justify-between items-center">
            <div class="">Total</div>
            <div class="">Rp. {{ number_format($transaction->total, 0, ',', '.') }}</div>
        </div>
    </div>



    <div class="flex mt-4 justify-center">
        @if ($paymentUrl)
            <flux:button href="{{ $paymentUrl }}" size="sm" variant="primary">Pay with Xendit</flux:button>
        @else
            <flux:button size="sm" variant="primary" disabled>Payment unavailable</flux:button>
        @endif
    </div>
</div>
