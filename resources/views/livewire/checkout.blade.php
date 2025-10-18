<div>
    <flux:container class="pt-20!">
        <flux:text position="center" size="xl">Final Step to Your Order</flux:text>
        <flux:text position="center">Review your details, choose your payment method, and get ready to receive your Bali
            Zoo merchandise.
        </flux:text>

        <div class="mt-4 grid gri1 md:grid-cols-2 gap-4 rounded p-4 bg-white dark:bg-neutral-700">
            <div class="">
                <flux:input wire:model.blur='name' label="Name"></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.blur='phone' label="Phone Number"></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.blur='email' label="Email"></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='address' label="Address"></flux:input>
            </div>
            <div class="">
                <flux:select wire:model.live='state.province_id' label="Province">
                    <flux:select.option value="">-- Select Province --</flux:select.option>
                    @foreach ($provinces as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:select wire:model.live='state.regency_id' label="City/Regency">
                    <flux:select.option value="">-- Select City/Regency --</flux:select.option>
                    @foreach ($regencies as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:select wire:model.live='state.district_id' label="District">
                    <flux:select.option value="">-- Select District --</flux:select.option>
                    @foreach ($districts as $item)
                        <flux:select.option value="{{ $item['id'] }}">{{ $item['name'] }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:input wire:model.live='state.postal_code' only_number label="Postal Code"></flux:input>
            </div>
        </div>

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

        <div class="mt-8 flex justify-center flex-wrap gap-4 p-4 bg-white dark:bg-neutral-700">
            @foreach ($shipments as $key => $item)
                <button
                    class="rounded p-4 space-y-4 text-center cursor-pointer {{ $shipment_id == $key ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600' }}"
                    wire:click='setShipment({{ $key }})'>
                    <div class="uppercase"> {{ $item['code'] }} {{ $item['service'] }}</div>
                    <div class="">Rp. {{ number_format($item['cost'], 0, ',', '.') }}</div>
                </button>
            @endforeach
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
                <div class="">Total: Rp. {{ number_format($subtotal + $shipment - $this->countDiscount(), 0, ',', '.') }}</div>

                <flux:button wire:click='save'>Pay</flux:button>
            </div>
        </div>
    </flux:container>

    @livewire('newslatter')
</div>
