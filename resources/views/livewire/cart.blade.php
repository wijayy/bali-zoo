<div class="">
    <flux:container class="pt-20!">
        <flux:text position="center" size="xl">Cart Overview</flux:text>
        <flux:text position="center">Check your selected merchandise and get ready to bring the magic of Bali Zoo home
        </flux:text>

        <div class="mt-4">
            <div class="grid grid-cols-5 py-2">
                <div class="flex gap-4">
                    <div class="w-10">#</div>
                    <div class="">Product</div>
                </div>
                <div class="text-center">Price</div>
                <div class="text-center">Quantity</div>
                <div class="text-center">Subtotal</div>
                <div class="text-center">Action</div>
            </div>

            @forelse ($carts as $key => $item)
                <div class="grid grid-cols-5 py-1">
                    <div class="flex gap-4">
                        <div class="w-10">{{ $loop->iteration }}</div>
                        <div class="">{{ $item['product']['name'] }}</div>
                    </div>
                    <div class="text-center">Rp. {{ number_format($item['product']['price'], 0, ',', '.') }}</div>
                    <div class="text-center">
                        <input type="number" min="1"
                            wire:input="updateQty({{ $item['id'] }}, $event.target.value)" value="{{ $item['qty'] }}"
                            class="border-b border-black w-full  px-2 py-1 text-center">
                        {{-- <div class="">{{ $item['qty'] }}</div> --}}
                    </div>
                    <div class="text-center">Rp.
                        {{ number_format($item['product']['price'] * $item['qty'], 0, ',', '.') }}</div>
                    <div class="flex justify-center">
                        <flux:button wire:click="delete({{ $item['id'] }})" variant="danger" icon="trash"
                            size="sm"></flux:button>
                    </div>
                </div>
            @empty
                <div class="w-full h-56 flex justify-center items-center">
                    Oops, your cart is empty. Add something to make it exciting!
                </div>
            @endforelse

            <div class="flex mt-8 justify-center">
                <div class="bg-mine-200 rounded p-4">
                    <div class=" text-center mb-4">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                    <flux:button variant="primary" class="rounded!" wire:click='checkout'>Checkout</flux:button>
                </div>
            </div>
        </div>
    </flux:container>

    @livewire('newslatter')
</div>
