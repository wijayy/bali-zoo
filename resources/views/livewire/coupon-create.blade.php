<form wire:submit='save' class="space-y-4">
    {{-- <flux:session>{{ $title }}</flux:session> --}}

    <flux:container-sidebar>
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-4">
            <div class="flex-1/2">
                <flux:input wire:model.live='code' :label="'Coupon code'"></flux:input>
            </div>
            <div class="flex-1/2">
                <flux:input wire:model.live='minimum' type="number" icon="rupiah" :label="'Minimum Purchase'">
                </flux:input>
            </div>
            <div class="flex-1/2">
                <flux:select wire:model.live='type' :label="'Discount type'">
                    <flux:select.option value="fixed">Fixed</flux:select.option>
                    <flux:select.option value="percentage">Percentage</flux:select.option>
                </flux:select>
            </div>

            <div class="flex-1/2">
                <flux:input wire:model.live='amount' type="number" :icon="$type == 'fixed' ? 'rupiah' : false"
                    :kbd="$type == 'percentage' ? '%' : ''" :label="'Discount'"></flux:input>
            </div>


            <div class="flex-1/4">
                <flux:input type="datetime-local" :label="'Start Date'" wire:model.live='start_time'>
                </flux:input>
            </div>
            <div class="flex-1/4">

                <flux:input type="datetime-local" :label="'End Date'" wire:model.live='end_time'></flux:input>
            </div>
            <div class="flex-1/2">
                <flux:input wire:model.live='limit' type="number" :label="'Limit'"></flux:input>
            </div>
            @if ($type == 'percentage')
                <div class="flex-1/2">
                    <flux:input wire:model.live='maximum' type="number" icon="rupiah"
                        :descriptionTrailing="'set 0 for unlimited discount'" :label="'Maximum discount'">
                    </flux:input>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <flux:label>Product</flux:label>
        </div>

        <div class="flex justify-center">
            <flux:button wire:click='selectAll'>Select All</flux:button>
        </div>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-4 mt-4">
            @foreach ($products as $item)
                <div class="p-2 flex border gap-2 items-center rounded-lg cursor-pointer
                {{ in_array($item->id, $selectedProducts) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}"
                    wire:click="toggleProduct({{ $item->id }})">
                    <div class="size-10 bg-center bg-no-repeat bg-cover rounded"
                        style="background-image: url({{ asset("storage/$item->image1") }});">
                    </div>
                    <div>{{ $item->name }}</div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-start mt-4">
            <flux:button variant="primary" type="submit">Save</flux:button>
        </div>
    </flux:container-sidebar>
</form>
