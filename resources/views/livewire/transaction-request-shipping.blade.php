<div>
    <form wire:submit='save' class="space-y-4">
        <flux:input wire:model.lazy="awb" label="AWB Number" type="text" required />

        <div class="flex gap-4"></div>
        <flux:button variant="danger" as href="{{ route('transaction.index') }}">Cancel</flux:button>
        <flux:button variant="primary" type="submit">Submit</flux:button>
    </form>
</div>
