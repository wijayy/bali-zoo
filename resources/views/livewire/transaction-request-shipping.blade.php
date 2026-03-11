<div>
    <form wire:submit='save' class="space-y-4">
        <flux:input wire:model.lazy="awb" label="AWB Number" type="text" required />
        <flux:button variant="primary" type="submit">Submit</flux:button>
    </form>
</div>
