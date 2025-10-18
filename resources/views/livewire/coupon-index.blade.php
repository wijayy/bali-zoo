<div class="space-y-4">
    {{-- <flux:session>All Coupon</flux:session> --}}

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button icon="plus" size="sm" variant="primary" as href="{{ route('coupon.create') }}">Add Coupon
            </flux:button>
        </div>

        <div class="mt-4">
            <div class="flex gap-4 py-2 font-semibold">
                <div class="w-10">#</div>
                <div class="w-1/6">Code</div>
                <div class="w-1/6 text-center">Minimum Purchase</div>
                <div class="w-1/6 text-center">Discount</div>
                <div class="w-1/6 text-center">Validity Period</div>
                <div class="w-1/6 text-center">Limit</div>
                <div class="w-1/6 text-center">Action</div>
            </div>

            @foreach ($coupons as $key => $item)
                <div class="flex items-center gap-4 py-1">
                    <div class="w-10">{{ $key + 1 }}</div>
                    <div class="w-1/6">{{ $item->code }}</div>
                    <div class="w-1/6 text-center">Rp. {{ number_format($item->minimum, 0, ',', '.') }}</div>
                    <div class="w-1/6 text-center">
                        @if ($item->type == 'fixed')
                            Rp. {{ number_format($item->amount, 0, ',', '.') }}
                        @else
                            {{ number_format($item->amount, 0, ',', '.') }}%{{ $item->maximum > 0 ? ', up to Rp. ' . number_format($item->maximum, 0, ',', '.') : '' }}
                        @endif
                    </div>
                    <div class="w-1/6 text-center">{{ $item->end_time->format('d M Y H:i') }}</div>
                    <div class="w-1/6 text-center">{{ $item->limit }}</div>
                    <div class="flex w-1/6 gap-2 justify-center">
                        <flux:button icon="pencil-square" variant="primary" color="sky" as
                            href="{{ route('coupon.edit', ['slug' => $item->slug]) }}" size="sm"></flux:button>
                        <flux:modal.trigger name="delete-{{ $key }}">
                            <flux:button icon="trash" size="sm" variant="primary" color="rose">
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal name="delete-{{ $key }}">
                            <div class="mt-4" action="{{ route('products.destroy', $item->slug) }}" method="post">
                                <div class="">Delete Coupon {{ $item->code }}? Once removed, it`s gone for good.</div>
                                <div class="flex justify-end">
                                    <flux:button variant="danger" wire:click='delete({{ $item->id }})'
                                        type="submit">Delete</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </div>
            @endforeach
        </div>

    </flux:container-sidebar>
</div>
