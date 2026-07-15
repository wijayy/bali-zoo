<div>
    <flux:container class="pt-20!">
        <flux:text position="center" size="xl">Final Step to Your Order</flux:text>
        <flux:text position="center">Review your details, choose your payment method, and get ready to receive your Bali
            Zoo merchandise.
        </flux:text>

        @if ($errors->any())
            <div class="mt-4 p-4 bg-rose-200 text-rose-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-4 grid grid-cols-1 gap-4 rounded p-4 bg-white dark:bg-neutral-700">
            <div wire:click='openGantiAlamatModal' class="border rounded-lg bg-white p-4 ring-2 ring-mine-400">
                <p>{{ $selectedAlamat->nama }}</p>
                <p>{{ $selectedAlamat->phone }}</p>
                <p>{{ $selectedAlamat->alamat }}</p>
                <p>{{ $selectedAlamat->village }}, {{ $selectedAlamat->district }}
                    {{ $selectedAlamat->regency }}
                    {{ $selectedAlamat->province }}</p>

                @if ($selectedAlamat->default)
                    <div class="text-mine-400 text-sm font-semibold">Alamat Default</div>
                @endif
            </div>
        </div>

        <flux:modal name="ganti-alamat">
            <div class="grid grid-cols-1 mt-4 gap-4">
                @foreach ($this->address as $address)
                    <div wire:click='gantiAlamat({{ $address->id }})'
                        class="border rounded-lg bg-white p-4 {{ $address->default ? 'ring-2 ring-mine-400' : 'ring-mine-300 ring-2' }}">
                        <p>{{ $address->nama }}</p>
                        <p>{{ $address->phone }}</p>
                        <p>{{ $address->alamat }}</p>
                        <p>{{ $address->village }}, {{ $address->district }}
                            {{ $address->regency }}
                            {{ $address->province }}</p>

                        @if ($address->default)
                            <div class="text-mine-400 text-sm font-semibold">Alamat Default</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </flux:modal>

        <div class="mt-8 space-y-2 rounded p-4 bg-white dark:bg-neutral-700">
            <div class="grid grid-cols-4 text-center gap-4 p-2">
                <div class="">Product</div>
                <div class="">Price</div>
                <div class="">Qty</div>
                <div class="">Subtotal</div>
            </div>

            @foreach ($carts as $item)
                {{-- @dd($item->product) --}}
                <div class="grid grid-cols-4 text-center p-1 gap-4">
                    <div class="">{{ $item->product->name }}</div>
                    <div class="">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</div>
                    <div class="">{{ $item->qty }}</div>
                    <div class="">Rp. {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 p-4 bg-white dark:bg-neutral-700">
            <div class=" text-center font-semibold text-xl">Shipping</div>
            <div class=" flex justify-center mt-4 flex-wrap gap-4 ">
                @foreach ($shipments as $key => $item)
                    <button
                        class="rounded p-4 space-y-4 text-center cursor-pointer {{ $shipment_id == $key ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600' }}"
                        wire:click='setShipment({{ $key }})'>
                        <div class="uppercase"> {{ $item['code'] }} {{ $item['service'] }}</div>
                        <div class="">Rp. {{ number_format($item['cost'], 0, ',', '.') }}</div>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <div class="rounded bg-mine-200 min-w-md flex flex-col items-center p-4 space-y-2">
                <flux:input wire:model.live='coupon' placeholder="Enter Coupon Code">
                </flux:input>
                <div class="">Subtotal: Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                <div class="">Shipping: Rp. {{ number_format($shipment, 0, ',', '.') }}</div>
                @if ($c ?? false)
                    <div class="">Coupon: {{ $c->code }}</div>
                    <div class="">Discount: Rp. {{ number_format($this->countDiscount(), 0, ',', '.') }}</div>
                @endif
                <div class="">Total: Rp.
                    {{ number_format($subtotal + $shipment - $this->countDiscount(), 0, ',', '.') }}</div>

                <flux:button wire:click='save'>Pay</flux:button>
            </div>
        </div>
    </flux:container>

    @livewire('newslatter')
</div>
