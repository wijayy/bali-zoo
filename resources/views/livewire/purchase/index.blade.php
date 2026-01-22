<div class="bg-white rounded-lg p-4 dark:bg-neutral-800">
    <div class="flex justify-end">
        <flux:button variant="primary" as href="{{ route('purchase.create') }}">Add Purchase</flux:button>
    </div>
    <div class="flex w-full font-semibold mt-4 gap-4">
        <div class="w-10">#</div>
        <div class="w-1/5">Purchase Number</div>
        <div class="flex gap-4 w-full">
            <div class="w-1/5 text-center">Product Purchased</div>
            <div class="w-1/5 text-center">Price</div>
            <div class="w-1/5 text-center">Quantity</div>
            <div class="w-1/5 text-center">Subtotal</div>
        </div>
        <div class="w-1/5 text-center">Total</div>
    </div>
    @foreach ($purchases as $item)
        <div class="flex w-full items-center gap-4 mt-2">
            <div class="w-10">{{ $loop->iteration }}</div>
            <div class="w-1/5">{{ $item->purchase_number }}</div>
            <div class="w-full">
                @foreach ($item->items as $itm)
                    <div class="flex gap-4 w-full mt-1">
                        <div class="w-1/5 text-center">{{ $itm->product->name }}</div>
                        <div class="w-1/5 text-center">{{ number_format($itm->price, 2) }}</div>
                        <div class="w-1/5 text-center">{{ $itm->qty }}</div>
                        <div class="w-1/5 text-center">{{ number_format($itm->subtotal, 2) }}</div>
                    </div>
                @endforeach
            </div>
            <div class="w-1/5 text-center">{{ number_format($item->total, 2) }}</div>
        </div>
    @endforeach
</div>
