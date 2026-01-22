<div class="bg-white dark:bg-neutral-800 rounded-lg gap-4">
    <form wire:submit="save" class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model='purchase_number' label="Purchase Number" type="text" readonly required></flux:input>
            <flux:input wire:model='purchase_date' label="Purchase Date" type="date" required></flux:input>
            <flux:select wire:model='payment_method' label="Payment Method" required>
                <option value="" disabled>Select Payment Method</option>
                <option value="cash">Cash</option>
                <option value="credit">Credit</option>
            </flux:select>
            <flux:input wire:model='name' label="Supplier Name" type="text" required></flux:input>
        </div>

        <div class="mt-4">
            <h3 class="font-semibold mb-2">Items</h3>
            @foreach ($items as $index => $item)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-2">
                    <flux:select wire:model="items.{{ $index }}.product_id"
                        wire:change="changeItem({{ $index }})" label="Product" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:input wire:model="items.{{ $index }}.price"
                        wire:change="changeItem({{ $index }})" label="Price" type="number" step="0.01"
                        required></flux:input>
                    <flux:input wire:model="items.{{ $index }}.qty" wire:change="changeItem({{ $index }})"
                        label="Quantity" type="number" required></flux:input>
                    <div class="flex items-end">
                        <flux:button type="button" variant="danger" wire:click="removeItem({{ $index }})">Remove
                        </flux:button>
                    </div>
                </div>
            @endforeach
            <flux:button type="button" wire:click="addItems()">Add Item</flux:button>
        </div>

        <div class="mt-4">
            <h3 class="font-semibold">Total: Rp. {{ number_format($total, 2) }}</h3>
        </div>

        <div class="mt-4">
            <flux:button type="submit">Submit</flux:button>
        </div>
    </form>
</div>
